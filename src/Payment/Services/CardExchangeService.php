<?php

namespace Modules\Payment\Services;

use Illuminate\Support\Facades\DB;
use Modules\Payment\Entities\CardExchange;
use Modules\Payment\Enums\CardExchangeStatus;
use Modules\Payment\Events\CardExchangeCompleted;
use Modules\Payment\Events\NewCardExchange;
use Modules\Payment\Jobs\SendToDTSR;
use Modules\Payment\Repositories\CardExchangeRepository;
use Modules\Payment\Repositories\PaymentRepository;

class CardExchangeService
{
    private $cardExchangeRepository;
    private $paymentRepository;
    private $paymentService;
    private $paymentCalculator;

    public function __construct(
        CardExchangeRepository $cardExchangeRepository,
        PaymentRepository $paymentRepository,
        PaymentService $paymentService,
        PaymentCalculator $paymentCalculator
    )
    {
        $this->cardExchangeRepository = $cardExchangeRepository;
        $this->paymentRepository = $paymentRepository;
        $this->paymentService = $paymentService;
        $this->paymentCalculator = $paymentCalculator;
    }

    public function create($attributes)
    {
        $cardExchange = $this->cardExchangeRepository->create($attributes);

        NewCardExchange::dispatch($cardExchange);

        return $cardExchange;
    }

    public function send(CardExchange $cardExchange)
    {
        SendToDTSR::dispatchSync($cardExchange);
    }

    public function accept(CardExchange $cardExchange)
    {
        $cardExchange = DB::transaction(function () use ($cardExchange) {
            $payment = $this->paymentRepository->find($cardExchange->payment_id);

            $cardExchange = $this->cardExchangeRepository->update([
                'real_value' => $cardExchange->value,
                'status' => CardExchangeStatus::COMPLETED
            ], $cardExchange->id);

            $this->paymentService->complete($payment, $cardExchange->id);

            return $cardExchange;
        });

        CardExchangeCompleted::dispatch($cardExchange);
    }

    public function deny(CardExchange $cardExchange, $feedback)
    {
        $cardExchange = DB::transaction(function () use ($cardExchange, $feedback) {
            $payment = $this->paymentRepository->find($cardExchange->payment_id);

            $cardExchange = $this->cardExchangeRepository->update([
                'feedback' => $feedback,
                'status' => CardExchangeStatus::FAILED
            ], $cardExchange->id);

            $this->paymentService->complete($payment, $cardExchange->id);

            return $cardExchange;
        });

        CardExchangeCompleted::dispatch($cardExchange);

        return $cardExchange;
    }

    public function callback($data)
    {
        $cardExchange = DB::transaction(function () use ($data) {
            $cardExchange = $this->cardExchangeRepository
                ->lockForUpdate()
                ->find($data['requestid']);

            if (!$cardExchange || $cardExchange->status->value != CardExchangeStatus::PROCESSING) {
                throw new \Exception('Giao dịch không tồn tại hoặc đã hoàn thành.');
            }

            $payment = $this->paymentRepository->lockForUpdate()
                ->find($cardExchange->payment_id);

            $cardValue = $data['CardValue'];
            if ($cardExchange->amount === $cardValue) {
                $cardExchange = $this->cardExchangeRepository->update([
                    'real_value' => $cardValue,
                    'status' => CardExchangeStatus::COMPLETED
                ], $cardExchange->id);
            } else {
                $cardExchange = $this->cardExchangeRepository->update([
                    'real_value' => $cardValue,
                    'receive_amount' => $this->paymentCalculator
                            ->calculateReceiveAmount($cardValue, $cardExchange->discount_rate) / 2,
                    'status' => CardExchangeStatus::COMPLETED
                ], $cardExchange->id);
            }

            $this->paymentService->complete($payment, $cardExchange->id);

            return $cardExchange;
        });

        CardExchangeCompleted::dispatch($cardExchange);

        return $cardExchange;
    }
}

<?php

namespace Modules\Payment\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;
use Modules\Payment\Entities\CardExchange;
use Modules\Payment\Enums\CardExchangeStatus;
use Modules\Payment\Enums\CardType;
use Modules\Payment\Events\CardExchangeCompleted;
use Modules\Payment\Events\CardExchangeProcessing;
use Modules\Payment\Repositories\CardExchangeRepository;
use Modules\Payment\Repositories\PaymentRepository;
use Modules\Payment\Services\DTSRService;
use Modules\Payment\Services\PaymentService;

class SendToDTSR implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $cardExchange;

    public function __construct(CardExchange $cardExchange)
    {
        $this->cardExchange = $cardExchange;
    }

    public function handle(
        PaymentRepository $paymentRepository,
        CardExchangeRepository $cardExchangeRepository,
        PaymentService $paymentService,
        DTSRService $dtsrService
    )
    {
        DB::transaction(function () use (
            $paymentRepository,
            $cardExchangeRepository,
            $paymentService,
            $dtsrService
        ){
            $cardExchange = $cardExchangeRepository->find($this->cardExchange->id);

            $result = $dtsrService->send([
                'Pin' => $cardExchange->code,
                'Seri' => $cardExchange->serial,
                'CardType' => [
                    CardType::VIETTEL => 1,
                    CardType::GARENA => 6,
                    CardType::ZING => 14,
                    CardType::VINAPHONE => 3,
                    CardType::MOBIFONE => 2,
                    CardType::GATE => 15,
                ][$cardExchange->type->value],
                'CardValue' => $cardExchange->value,
                'requestid' => $cardExchange->id
            ]);

            $payment = $paymentRepository->lockForUpdate()
                ->find($cardExchange->payment_id);

            if ($result['success']) {
                $cardExchangeRepository->update([
                    'status' => CardExchangeStatus::PROCESSING
                ], $cardExchange->id);

                CardExchangeProcessing::dispatch($cardExchange);
            } else {
                $cardExchangeRepository->update([
                    'feedback' => $result['message'],
                    'status' => CardExchangeStatus::FAILED
                ], $cardExchange->id);

                $paymentService->complete($payment, $cardExchange->id);

                CardExchangeCompleted::dispatch($cardExchange);
            }
        });
    }

    public function uniqueId()
    {
        return $this->cardExchange->id;
    }
}

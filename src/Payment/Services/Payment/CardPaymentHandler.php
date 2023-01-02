<?php

namespace Modules\Payment\Services\Payment;

use Illuminate\Support\Facades\DB;
use Modules\Order\Enums\OrderStatus;
use Modules\Order\Repositories\OrderRepository;
use Modules\Order\Services\OrderService;
use Modules\Payment\Enums\BankTransferStatus;
use Modules\Payment\Enums\CardExchangeStatus;
use Modules\Payment\Enums\PaymentStatus;
use Modules\Payment\Enums\PaymentType;
use Modules\Payment\Repositories\CardExchangeRepository;
use Modules\Payment\Repositories\CardRepository;
use Modules\Payment\Repositories\PaymentRepository;
use Modules\Payment\Services\CardExchangeService;
use Modules\Payment\Services\PaymentCalculator;
use Modules\User\Services\WalletService;

class CardPaymentHandler implements PaymentHandler
{
    private $cardRepository;
    private $cardExchangeRepository;
    private $paymentCalculator;
    private $paymentRepository;
    private $orderRepository;
    private $orderService;
    private $walletService;
    private $cardExchangeService;

    public function __construct(
        CardRepository         $cardRepository,
        CardExchangeRepository $cardExchangeRepository,
        PaymentCalculator      $paymentCalculator,
        PaymentRepository      $paymentRepository,
        OrderRepository        $orderRepository,
        OrderService $orderService,
        WalletService          $walletService,
        CardExchangeService  $cardExchangeService
    )
    {
        $this->cardRepository = $cardRepository;
        $this->cardExchangeRepository = $cardExchangeRepository;
        $this->paymentCalculator = $paymentCalculator;
        $this->paymentRepository = $paymentRepository;
        $this->orderRepository = $orderRepository;
        $this->orderService = $orderService;
        $this->walletService = $walletService;
        $this->cardExchangeService = $cardExchangeService;
    }

    public function create($attributes)
    {
        return DB::transaction(function () use ($attributes) {
            $payment = $this->paymentRepository->create(array_merge($attributes, [
                'amount' => collect($attributes['cards'])->reduce(function ($amount, $card) {
                    return $amount + $card['value'];
                }, 0),
                'discount_rate' => 0,
                'total' => count($attributes['cards'])
            ]));

            foreach ($attributes['cards'] as $cardAttributes) {
                $card = $this->cardRepository->find($cardAttributes['id']);

                $this->cardExchangeService->create([
                    'payment_id' => $payment->id,
                    'card_id' => $card->id,
                    'type' => $card->type,
                    'serial' => $cardAttributes['serial'],
                    'code' => $cardAttributes['code'],
                    'value' => $cardAttributes['value'],
                    'discount_rate' => $card->discount_rate,
                    'receive_amount' => $this->paymentCalculator->calculateReceiveAmount(
                        $cardAttributes['value'],
                        $card->discount_rate
                    )
                ]);
            }

            return $payment;
        });
    }

    public function complete($paymentId, $targetId)
    {
        return DB::transaction(function () use ($paymentId, $targetId) {
            $payment = $this->paymentRepository->find($paymentId);
            $cardExchange = $this->cardExchangeRepository->find($targetId);
            $totalReceiveAmount = $payment->receive_amount;

            if ($cardExchange->status->value === CardExchangeStatus::COMPLETED) {
                $totalReceiveAmount += $cardExchange->receive_amount;
            }

            $isFinished = $payment->cardExchanges()->whereIn('status', [
                CardExchangeStatus::PENDING,
                CardExchangeStatus::PROCESSING
            ])->doesntExist();

            switch ($payment->type) {
                case PaymentType::RECHARGE:
                    if ($cardExchange->status->value === CardExchangeStatus::COMPLETED) {
                        $this->walletService->deposit(
                            $payment->payer_id,
                            $cardExchange->receive_amount,
                            'Nạp tiền'
                        );
                    }
                    break;
                case PaymentType::ORDER:
                    if ($isFinished) {
                        $order = $this->orderRepository->find($payment->order_id);

                        if ($totalReceiveAmount >= $order->total) {
                            $this->orderService->pay($order->id);
                        } else {
                            $this->walletService->deposit(
                                $payment->payer_id,
                                $totalReceiveAmount,
                                'Hoàn tiền thanh toán đơn hàng'
                            );
                        }
                    }
                    break;
            }

            return $this->paymentRepository->update([
                'receive_amount' => $totalReceiveAmount,
                'status' => $isFinished ? PaymentStatus::COMPLETED : $payment->status
            ], $payment->id);
        });
    }

    public function cancel($paymentId)
    {
        return DB::transaction(function () use ($paymentId) {
            $payment = $this->paymentRepository->find($paymentId);

            $payment->card_exchanges()->update([
                'status' => BankTransferStatus::CANCELED
            ]);

            if ($payment->type->value === PaymentType::ORDER) {
                $this->orderService->cancel($payment->order_id);
            }

            $this->paymentRepository->update([
                'status' => PaymentStatus::CANCELED
            ], $payment->id);
        });
    }

    public function calculateOrderAmount($total, $data = [])
    {
        return 0;
    }
}

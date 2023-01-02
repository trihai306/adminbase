<?php

namespace Modules\Payment\Services\Payment;

use Illuminate\Support\Facades\DB;
use Modules\Order\Enums\OrderStatus;
use Modules\Order\Repositories\OrderRepository;
use Modules\Order\Services\OrderService;
use Modules\Payment\Enums\BankTransferStatus;
use Modules\Payment\Enums\EwalletTransferStatus;
use Modules\Payment\Enums\PaymentStatus;
use Modules\Payment\Enums\PaymentType;
use Modules\Payment\Repositories\EwalletRepository;
use Modules\Payment\Repositories\EwalletTransferRepository;
use Modules\Payment\Repositories\PaymentRepository;
use Modules\Payment\Services\PaymentCalculator;
use Modules\User\Services\WalletService;

class EwalletTransferPaymentHandler implements PaymentHandler
{
    private $ewalletRepository;
    private $ewalletTransferRepository;
    private $paymentCalculator;
    private $paymentRepository;
    private $orderRepository;
    private $orderService;
    private $walletService;

    public function __construct(
        EwalletRepository $ewalletRepository,
        EwalletTransferRepository $ewalletTransferRepository,
        PaymentCalculator $paymentCalculator,
        PaymentRepository $paymentRepository,
        OrderRepository $orderRepository,
        OrderService $orderService,
        WalletService $walletService
    )
    {
        $this->ewalletRepository = $ewalletRepository;
        $this->ewalletTransferRepository = $ewalletTransferRepository;
        $this->paymentCalculator = $paymentCalculator;
        $this->paymentRepository = $paymentRepository;
        $this->orderRepository = $orderRepository;
        $this->orderService = $orderService;
        $this->walletService = $walletService;
    }

    public function create($attributes)
    {
        return DB::transaction(function () use ($attributes) {
            $ewallet = $this->ewalletRepository->find($attributes['ewallet_id']);

            $payment = $this->paymentRepository->create(array_merge($attributes, [
                'discount_rate' => $ewallet->discount_rate,
                'expire_at' => now()->addMinutes(10),
            ]));

            $this->ewalletTransferRepository->create([
                'payment_id' => $payment->id,
                'ewallet_id' => $ewallet->id,
                'ref' => null,
                'content' => "MK $payment->id",
                'amount' => $payment->amount,
                'discount_rate' => $ewallet->discount_rate,
                'receive_amount' => $this->paymentCalculator->calculateReceiveAmount(
                    $payment->amount,
                    $ewallet->discount_rate
                ),
                'expired_at' => now()->addMinutes(10),
                'status' => EwalletTransferStatus::PENDING
            ]);

            return $payment;
        });
    }

    public function complete($paymentId, $targetId)
    {
        return DB::transaction(function () use ($paymentId, $targetId) {
            $payment = $this->paymentRepository->find($paymentId);
            $ewalletTransfer = $this->ewalletTransferRepository->find($targetId);

            if ($ewalletTransfer->status->value !== BankTransferStatus::COMPLETED) {
                return $this->paymentRepository->update([
                    'status' => PaymentStatus::FAILED
                ], $payment->id);
            }

            switch ($payment->type) {
                case PaymentType::RECHARGE:
                    $this->walletService->deposit(
                        $payment->payer_id,
                        $ewalletTransfer->receive_amount,
                        'Nạp tiền'
                    );
                    break;
                case PaymentType::ORDER:
                    $order = $this->orderRepository->find($payment->order_id);

                    if ($ewalletTransfer->receive_amount >= $order->total) {
                        $this->orderService->pay($order->id);
                    } else {
                        $this->walletService->deposit(
                            $payment->payer_id,
                            $ewalletTransfer->receive_amount,
                            'Hoàn tiền thanh toán đơn hàng'
                        );
                    }
                    break;
            }

            return $this->paymentRepository->update([
                'receive_amount' => $ewalletTransfer->receive_amount,
                'status' => PaymentStatus::COMPLETED
            ], $payment->id);
        });
    }

    public function cancel($paymentId)
    {
        return DB::transaction(function () use ($paymentId) {
            $payment = $this->paymentRepository->find($paymentId);

            $payment->ewallet_transfer()->update([
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
        $ewallet = $this->ewalletRepository->find($data['ewallet_id']);

        return $this->paymentCalculator->calculateAmount(
            $total,
            $ewallet->discount_rate
        );
    }
}

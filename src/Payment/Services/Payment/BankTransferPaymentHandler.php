<?php

namespace Modules\Payment\Services\Payment;

use Illuminate\Support\Facades\DB;
use Modules\Order\Enums\OrderStatus;
use Modules\Order\Repositories\OrderRepository;
use Modules\Order\Services\OrderService;
use Modules\Payment\Enums\BankTransferStatus;
use Modules\Payment\Enums\PaymentStatus;
use Modules\Payment\Enums\PaymentType;
use Modules\Payment\Repositories\BankRepository;
use Modules\Payment\Repositories\BankTransferRepository;
use Modules\Payment\Repositories\PaymentRepository;
use Modules\Payment\Services\PaymentCalculator;
use Modules\User\Services\WalletService;

class BankTransferPaymentHandler implements PaymentHandler
{
    private $bankRepository;
    private $bankTransferRepository;
    private $paymentCalculator;
    private $paymentRepository;
    private $orderRepository;
    private $orderService;
    private $walletService;

    public function __construct(
        BankRepository $bankRepository,
        BankTransferRepository $bankTransferRepository,
        PaymentCalculator $paymentCalculator,
        PaymentRepository $paymentRepository,
        OrderRepository $orderRepository,
        OrderService $orderService,
        WalletService $walletService
    )
    {
        $this->bankRepository = $bankRepository;
        $this->bankTransferRepository = $bankTransferRepository;
        $this->paymentCalculator = $paymentCalculator;
        $this->paymentRepository = $paymentRepository;
        $this->orderRepository = $orderRepository;
        $this->orderService = $orderService;
        $this->walletService = $walletService;
    }

    public function create($attributes)
    {
        return DB::transaction(function () use ($attributes) {
            $bank = $this->bankRepository->find($attributes['bank_id']);

            $payment = $this->paymentRepository->create(array_merge($attributes, [
                'discount_rate' => $bank->discount_rate,
                'expire_at' => now()->addMinutes(10),
            ]));

            $this->bankTransferRepository->create([
                'payment_id' => $payment->id,
                'bank_id' => $bank->id,
                'ref' => null,
                'content' => "MK $payment->id",
                'amount' => $payment->amount,
                'discount_rate' => $bank->discount_rate,
                'receive_amount' => $this->paymentCalculator->calculateReceiveAmount(
                    $payment->amount,
                    $bank->discount_rate
                ),
                'status' => BankTransferStatus::PENDING
            ]);

            return $payment;
        });
    }

    public function complete($paymentId, $targetId)
    {
        return DB::transaction(function () use ($paymentId, $targetId) {
            $payment = $this->paymentRepository->find($paymentId);
            $bankTransfer = $this->bankTransferRepository->find($targetId);

            if ($bankTransfer->status->value !== BankTransferStatus::COMPLETED) {
                return $this->paymentRepository->update([
                    'status' => PaymentStatus::FAILED
                ], $payment->id);
            }

            switch ($payment->type) {
                case PaymentType::RECHARGE:
                    $this->walletService->deposit(
                        $payment->payer_id,
                        $bankTransfer->receive_amount,
                        'Nạp tiền'
                    );
                    break;
                case PaymentType::ORDER:
                    $order = $this->orderRepository->find($payment->order_id);

                    if ($bankTransfer->receive_amount >= $order->total) {
                        $this->orderService->pay($order->id);
                    } else {
                        $this->walletService->deposit(
                            $payment->payer_id,
                            $bankTransfer->receive_amount,
                            'Hoàn tiền thanh toán đơn hàng'
                        );
                    }
                    break;
            }

            return $this->paymentRepository->update([
                'receive_amount' => $bankTransfer->receive_amount,
                'status' => PaymentStatus::COMPLETED
            ], $payment->id);
        });
    }

    public function cancel($paymentId)
    {
        return DB::transaction(function () use ($paymentId) {
            $payment = $this->paymentRepository->find($paymentId);

            $payment->bank_transfer()->update([
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
        $bank = $this->bankRepository->find($data['bank_id']);

        return $this->paymentCalculator->calculateAmount(
            $total,
            $bank->discount_rate
        );
    }
}

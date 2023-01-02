<?php

namespace Modules\Payment\Services\Payment;

use Illuminate\Support\Facades\DB;
use Modules\Order\Services\OrderService;
use Modules\Payment\Enums\PaymentStatus;
use Modules\Payment\Enums\PaymentType;
use Modules\Payment\Repositories\PaymentRepository;
use Modules\User\Services\WalletService;

class BalancePaymentHandler implements PaymentHandler
{
    private $walletService;
    private $paymentRepository;
    private $orderService;

    public function __construct(
        WalletService $walletService,
        PaymentRepository $paymentRepository,
        OrderService $orderService
    )
    {
        $this->walletService = $walletService;
        $this->paymentRepository = $paymentRepository;
        $this->orderService = $orderService;
    }

    public function create($attributes)
    {
        if ($attributes['type'] !== PaymentType::ORDER) {
            throw new \Exception('Kiểu thanh toán không được hỗ trợ.');
        }

        return DB::transaction(function () use ($attributes) {
            $payment = $this->paymentRepository->create(array_merge($attributes, [
                'discount_rate' => 0,
                'receive_amount' => $attributes['amount'],
                'status' => PaymentStatus::COMPLETED
            ]));

            $this->walletService->withdraw(
                $attributes['payer_id'],
                $attributes['amount'],
                "Thanh toán hóa đơn #{$payment->order_id}",
            );

            $this->orderService->pay($payment->order_id);

            return $payment;
        });
    }

    public function complete($paymentId, $targetId)
    {
    }

    public function cancel($paymentId)
    {
    }

    public function calculateOrderAmount($total, $data = [])
    {
        return $total;
    }
}

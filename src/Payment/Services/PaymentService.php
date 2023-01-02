<?php

namespace Modules\Payment\Services;

use Modules\Payment\Entities\Payment;
use Modules\Payment\Events\PaymentCanceled;
use Modules\Payment\Events\PaymentCompleted;
use Modules\Payment\Events\NewPayment;
use Modules\Payment\Jobs\CancelExpiredPayment;
use Modules\Payment\Repositories\PaymentMethodRepository;
use Modules\Payment\Services\Payment\PaymentManager;

class PaymentService
{
    private $paymentMethodRepository;
    private $paymentManager;

    public function __construct(
        PaymentMethodRepository $paymentMethodRepository,
        PaymentManager $paymentManager
    )
    {
        $this->paymentMethodRepository = $paymentMethodRepository;
        $this->paymentManager = $paymentManager;
    }

    public function create(array $attributes)
    {
        $paymentMethod = $this->paymentMethodRepository->find(
            $attributes['method_id']
        );

        $attributes['method_type'] = $paymentMethod->type->value;

        $paymentHandler = $this->paymentManager->driver($attributes['method_type']);

        $payment =  $paymentHandler->create($attributes);

        CancelExpiredPayment::dispatch($payment)->delay($payment->expire_at);

        NewPayment::dispatch($payment);

        return $payment;
    }

    public function complete(Payment $payment, $targetId)
    {
        $paymentHandler = $this->paymentManager->driver($payment->method_type->value);

        $payment = $paymentHandler->complete($payment->id, $targetId);

        PaymentCompleted::dispatch($payment);
    }

    public function cancel(Payment $payment)
    {
        $paymentHandler = $this->paymentManager->driver($payment->method_type->value);

        $paymentHandler->cancel($payment->id);

        PaymentCanceled::dispatch($payment);
    }

    public function calculateOrderAmount($methodType, $total, $data = [])
    {
        $paymentHandler = $this->paymentManager->driver($methodType);

        return $paymentHandler->calculateOrderAmount($total, $data);
    }
}

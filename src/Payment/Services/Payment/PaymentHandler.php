<?php

namespace Modules\Payment\Services\Payment;

interface PaymentHandler
{
    public function create($attributes);
    public function complete($paymentId, $targetId);
    public function cancel($paymentId);
    public function calculateOrderAmount($total, $data = []);
}

<?php

namespace Modules\Payment\Services;

use Modules\Payment\Enums\PaymentMethodType;

class PaymentCalculator
{
    public function calculateAmount($receiveAmount, $discountRate = 0)
    {
        return $receiveAmount / (100 - $discountRate) * 100;
    }

    public function calculateReceiveAmount($amount, $discountRate = 0)
    {
        return $amount * (100 - $discountRate) / 100;
    }
}

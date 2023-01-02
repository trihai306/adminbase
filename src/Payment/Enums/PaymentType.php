<?php

namespace Modules\Payment\Enums;

use BenSampo\Enum\Enum;

final class PaymentType extends Enum
{
    const RECHARGE = 'recharge';
    const ORDER = 'order';
}

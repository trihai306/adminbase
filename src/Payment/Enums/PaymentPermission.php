<?php

namespace Modules\Payment\Enums;

use BenSampo\Enum\Enum;

class PaymentPermission extends Enum
{
    const LIST = 'payment.list';
    const DETAIL = 'payment.detail';
}

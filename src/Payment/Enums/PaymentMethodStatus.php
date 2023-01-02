<?php

namespace Modules\Payment\Enums;

use BenSampo\Enum\Enum;

class PaymentMethodStatus extends Enum
{
    const ACTIVATED = 'activated';
    const DEACTIVATED = 'deactivated';
}

<?php

namespace Modules\Payment\Enums;

use BenSampo\Enum\Enum;

class PaymentStatus extends Enum
{
    const PENDING = 'pending';
    const COMPLETED = 'completed';
    const FAILED = 'failed';
    const CANCELED = 'canceled';
}

<?php

namespace Modules\Payment\Enums;

use BenSampo\Enum\Enum;

class CardExchangeStatus extends Enum
{
    const PENDING = 'pending';
    const PROCESSING = 'processing';
    const COMPLETED = 'completed';
    const FAILED = 'failed';
    const CANCELED = 'canceled';
}

<?php

namespace Modules\Order\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

class OrderItemStatus extends Enum implements LocalizedEnum
{
    const NEW = 'new';
    const PENDING = 'pending';
    const DELIVERING = 'delivering';
    const COMPLETED = 'completed';
    const CANCELED = 'canceled';
}

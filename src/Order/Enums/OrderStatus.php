<?php

namespace Modules\Order\Enums;

use BenSampo\Enum\Enum;

class OrderStatus extends Enum
{
    const NEW = 'new';
    const PENDING = 'pending';
    const DELIVERING = 'delivering';
    const COMPLETED = 'completed';
    const CANCELED = 'canceled';
}

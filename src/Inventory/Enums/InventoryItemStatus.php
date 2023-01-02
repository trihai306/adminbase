<?php

namespace Modules\Inventory\Enums;

use BenSampo\Enum\Enum;

class InventoryItemStatus extends Enum
{
    const AVAILABLE = 'available';
    const SOLD = 'sold';
}

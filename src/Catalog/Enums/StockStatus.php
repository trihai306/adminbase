<?php

namespace Modules\Catalog\Enums;

use BenSampo\Enum\Enum;

class StockStatus extends Enum
{
    const IN_STOCK = 'in_stock';
    const OUT_OF_STOCK = 'out_of_stock';
}

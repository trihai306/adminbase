<?php

namespace Modules\Catalog\Enums;

use BenSampo\Enum\Enum;

class OrderType extends Enum
{
    const IMMEDIATE = 'immediate';
    const ORDER = 'order';
    const PREORDER = 'preorder';
}

<?php

namespace Modules\Catalog\Enums;

use BenSampo\Enum\Enum;

class ProductStatus extends Enum
{
    const DRAFT = 'draft';
    const PUBLISHED = 'published';
}

<?php

namespace Modules\Catalog\Repositories;

use Modules\Core\Repositories\Repository;

interface VariantRepository extends Repository
{
    public function deleteNotIn(array $ids);
    public function resetAllDiscountPrice();
}

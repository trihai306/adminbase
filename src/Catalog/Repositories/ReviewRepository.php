<?php

namespace Modules\Catalog\Repositories;

use Modules\Core\Repositories\Repository;

interface ReviewRepository extends Repository
{
    public function getRatingsCount($productId);
    public function getRatingsAvg($productId);
}

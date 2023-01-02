<?php

namespace Modules\Catalog\Repositories;

use Modules\Core\Repositories\Repository;

interface PromotionRepository extends Repository
{
    public function findByCode($code);
    public function getAllActivated();
}

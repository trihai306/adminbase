<?php

namespace Modules\Catalog\Repositories;

use Modules\Core\Repositories\Repository;

interface CategoryRepository extends Repository
{
    public function findByCode($code);
    public function getTrees();
}

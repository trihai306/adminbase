<?php

namespace Modules\Catalog\Repositories;

use Modules\Core\Repositories\Repository;

interface CollectionRepository extends Repository
{
    public function findByCode($code);
}

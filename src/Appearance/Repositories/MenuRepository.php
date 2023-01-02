<?php

namespace Modules\Appearance\Repositories;

use Modules\Core\Repositories\Repository;

interface MenuRepository extends Repository
{
    public function findByCode($code);
}

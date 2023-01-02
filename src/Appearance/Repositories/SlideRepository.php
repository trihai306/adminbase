<?php

namespace Modules\Appearance\Repositories;

use Modules\Core\Repositories\Repository;

interface SlideRepository extends Repository
{
    public function findByCode($code);
}

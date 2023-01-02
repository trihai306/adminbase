<?php

namespace Modules\Payment\Repositories;

use Modules\Core\Repositories\Repository;

interface CardRepository extends Repository
{
    public function deleteNotInIds($ids);
}

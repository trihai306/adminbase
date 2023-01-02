<?php

namespace Modules\Payment\Repositories;

use Modules\Core\Repositories\Repository;

interface EwalletRepository extends Repository
{
    public function deleteNotInIds($ids);
}

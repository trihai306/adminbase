<?php

namespace Modules\Payment\Repositories;

use Modules\Core\Repositories\Repository;

interface BankRepository extends Repository
{
    public function deleteNotInIds($ids);
}

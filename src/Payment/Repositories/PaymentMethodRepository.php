<?php

namespace Modules\Payment\Repositories;

use Modules\Core\Repositories\Repository;

interface PaymentMethodRepository extends Repository
{
    public function findByCode($code);
}

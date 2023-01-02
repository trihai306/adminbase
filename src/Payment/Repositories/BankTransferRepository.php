<?php

namespace Modules\Payment\Repositories;

use Modules\Core\Repositories\Repository;

interface BankTransferRepository extends Repository
{
    public function findByPaymentId($paymendId);
}

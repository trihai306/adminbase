<?php

namespace Modules\User\Repositories;

use Modules\Core\Repositories\Repository;

interface WalletRepository extends Repository
{
    public function findByUserId($userId);
    public function increaseBalance($userId, $amount);
    public function decreaseBalance($userId, $amount);
}

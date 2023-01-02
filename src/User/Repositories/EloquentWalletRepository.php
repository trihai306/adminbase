<?php

namespace Modules\User\Repositories;

use Modules\Core\Repositories\EloquentRepository;
use Modules\User\Entities\Wallet;

class EloquentWalletRepository extends EloquentRepository implements WalletRepository
{
    public function __construct(Wallet $model)
    {
        parent::__construct($model);
    }

    public function findByUserId($userId)
    {
        return $this->model->newQuery()
            ->where('user_id', $userId)
            ->first();
    }

    public function increaseBalance($userId, $amount)
    {
        return $this->model->newQuery()
            ->where('user_id', $userId)
            ->increment('balance', $amount);
    }

    public function decreaseBalance($userId, $amount)
    {
        return $this->model->newQuery()
            ->where('user_id', $userId)
            ->decrement('balance', $amount);
    }
}

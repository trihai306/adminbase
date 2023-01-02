<?php

namespace Modules\User\Repositories;

use Modules\Core\Repositories\EloquentRepository;
use Modules\User\Entities\LoginHistory;

class EloquentLoginHistoryRepository extends EloquentRepository implements LoginHistoryRepository
{
    protected $allowedSorts = [
        'id',
        'user_id',
        'updated_at',
        'created_at'
    ];

    protected $allowedIncludes = [];

    public function __construct(LoginHistory $model)
    {
        parent::__construct($model);
    }

    public function query(array $conditions)
    {
        $query = $this->model->newQuery();

        if (isset($conditions['user_id'])) {
            $query->where('user_id', $conditions['user_id']);
        }

        return parent::executeQuery($conditions, $query);
    }
}

<?php

namespace Modules\User\Repositories;

use Modules\Core\Repositories\EloquentRepository;
use Modules\Core\Repositories\Filters\BetweenColumnFilter;
use Modules\User\Entities\Transaction;
use Spatie\QueryBuilder\AllowedFilter;

class EloquentTransactionRepository extends EloquentRepository implements TransactionRepository
{
    protected $allowedSearch = true;

    protected $allowedFilters = [
        'id',
        'user_id',
        'content'
    ];

    protected $allowedSorts = [
        'id',
        'user_id',
        'amount',
        'content',
        'balance',
        'updated_at',
        'created_at'
    ];

    protected $allowedIncludes = [
        'user'
    ];

    public function __construct(Transaction $model)
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

    protected function allowedFilters(): array
    {
        return array_merge(parent::allowedFilters(), [
            AllowedFilter::custom(
                'updated_range',
                new BetweenColumnFilter('updated_at')
            ),
            AllowedFilter::custom(
                'created_range',
                new BetweenColumnFilter('created_at')
            )
        ]);
    }
}

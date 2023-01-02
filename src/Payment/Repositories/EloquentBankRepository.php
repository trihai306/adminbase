<?php

namespace Modules\Payment\Repositories;

use Modules\Core\Repositories\EloquentRepository;
use Modules\Payment\Entities\Bank;

class EloquentBankRepository extends EloquentRepository implements BankRepository
{
    protected $allowedSearch = true;

    protected $allowedFilters = [
        'id',
        'payment_method_id',
        'name',
        'account_number',
        'account_name',
        'branch',
        'enabled'
    ];

    protected $allowedSorts = [
        'id',
        'payment_method_id',
        'name',
        'account_number',
        'account_name',
        'branch',
        'enabled',
        'updated_at',
        'created_at'
    ];

    public function __construct(Bank $model)
    {
        parent::__construct($model);
    }

    public function query(array $conditions)
    {
        $query = $this->model->newQuery();

        if (isset($conditions['payment_method_id'])) {
            $query->where('payment_method_id', $conditions['payment_method_id']);
        }

        return parent::executeQuery($conditions, $query);
    }

    public function deleteNotInIds($ids)
    {
        return $this->model->newQuery()
            ->whereNotIn('id', $ids)
            ->delete();
    }
}

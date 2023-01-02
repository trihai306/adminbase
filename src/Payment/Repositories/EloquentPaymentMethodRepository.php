<?php

namespace Modules\Payment\Repositories;

use Modules\Core\Repositories\EloquentRepository;
use Modules\Payment\Entities\PaymentMethod;

class EloquentPaymentMethodRepository extends EloquentRepository implements PaymentMethodRepository
{
    protected $allowedFilters = [
        'id',
        'type',
        'code',
        'name',
        'checkout_enabled',
        'recharge_enabled',
    ];

    protected $allowedSorts =  [
        'id',
        'type',
        'code',
        'name',
        'enabled',
        'updated_at',
        'created_at'
    ];

    protected $allowedIncludes = [
        'banks',
        'cards',
        'ewallets'
    ];

    public function __construct(PaymentMethod $model)
    {
        parent::__construct($model);
    }

    public function findByCode($code)
    {
        return $this->model->newQuery()
            ->where('code', $code)
            ->first();
    }

    public function query(array $conditions)
    {
        $query = $this->model->newQuery();

        if (isset($conditions['status'])) {
            $query->where('status', $conditions['status']);
        }

        return parent::executeQuery($conditions, $query);
    }
}

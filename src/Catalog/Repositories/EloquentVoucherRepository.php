<?php

namespace Modules\Catalog\Repositories;

use Modules\Catalog\Entities\Voucher;
use Modules\Core\Repositories\EloquentRepository;

class EloquentVoucherRepository extends EloquentRepository implements VoucherRepository
{
    protected $allowedSearch = true;

    protected $allowedFilters = [
        'id',
        'name',
        'code',
        'discount',
        'max_money',
        'quality',
        'point',
        'start_at',
        'end_at',
        'options',
        'status',
    ];

    protected $allowedSorts = [
        'id',
        'name',
        'code',
        'discount',
        'max_money',
        'quality',
        'point',
        'start_at',
        'end_at',
        'status',
        'options',
        'updated_at',
        'created_at'
    ];

    protected $allowedIncludes = [
        'variant_ids',
        'user_ids',
        'variants',
        'users',
        'options',
        'product_ids',
        'products'
    ];

    public function __construct(Voucher $model)
    {
        parent::__construct($model);
    }

    public function query(array $conditions)
    {
        $query = $this->model->newQuery();
        if (isset($conditions[0]['user_id'])) {
            $query = $query->whereHas('users', function ($query) use ($conditions) {
                return $query->where('user_id', $conditions[0]['user_id']);
            });
        }
        if (isset($conditions[0]['quality'])) {
            $query->where('quality', '>', 0);
        }
        return $this->executeQuery($conditions, $query);
    }

}

<?php

namespace Modules\Order\Repositories;

use Illuminate\Support\Facades\DB;
use Modules\Core\Repositories\EloquentRepository;
use Modules\Order\Entities\Order;

class EloquentOrderRepository extends EloquentRepository implements OrderRepository
{
    protected $allowedSearch = true;

    protected $allowedFilters = [
        'id',
        'buyer_id',
        'transaction_id',
        'status'
    ];

    protected $allowedSorts = [
        'id',
        'buyer_id',
        'transaction_id',
        'total',
        'updated_at',
        'created_at'
    ];

    protected $allowedIncludes = [
        'buyer',
        'payment_method',
        'payment',
        'payment.bank_transfer.bank',
        'payment.ewallet_transfer.ewallet',
        'transaction',
        'items'
    ];

    public function __construct(Order $model)
    {
        parent::__construct($model);
    }

    public function create(array $attributes)
    {
        return DB::transaction(function () use ($attributes) {
            $order = parent::create($attributes);

            if (isset($attributes['items'])) {
                $order->items()->createMany($attributes['items']);
            }

            return $order;
        });
    }
}

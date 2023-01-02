<?php

namespace Modules\Order\Repositories;

use Modules\Core\Repositories\EloquentRepository;
use Modules\Core\Repositories\Filters\BetweenColumnFilter;
use Modules\Core\Repositories\Filters\RelationColumnFilter;
use Modules\Order\Entities\OrderItem;
use Spatie\QueryBuilder\AllowedFilter;

class EloquentOrderItemRepository extends EloquentRepository implements OrderItemRepository
{
    protected $allowedSearch = true;

    protected $allowedFilters = [
        'order_id',
        'variant_id',
        'code',
        'name',
        'order_type',
        'status'
    ];

    protected $allowedSorts = [
        'id',
        'order_id',
        'variant_id',
        'code',
        'name',
        'quantity',
        'price',
        'order_type',
        'status',
        'updated_at',
        'created_at'
    ];

    protected $allowedIncludes = [
        'order',
        'order.buyer',
        'variant',
        'delivery_inventory_items',
        'delivery_inventory_items_count',
        'rating'
    ];

    public function __construct(OrderItem $model)
    {
        parent::__construct($model);
    }

    public function query(array $conditions)
    {
        $query = $this->model->newQuery();

        if (isset($conditions['buyer_id'])) {
            $query = $query->whereHas('order', function ($query) use ($conditions) {
                return $query->where('buyer_id', $conditions['buyer_id']);
            });
        }

        return $this->executeQuery($conditions, $query);
    }

    public function allowedFilters(): array
    {
        return array_merge(parent::allowedFilters(), [
            AllowedFilter::custom(
                'buyer_id',
                new RelationColumnFilter('order', 'buyer_id')
            ),
            AllowedFilter::custom(
                'created_range',
                new BetweenColumnFilter('created_at')
            ),
        ]);
    }
}

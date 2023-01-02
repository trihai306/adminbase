<?php

namespace Modules\Inventory\Repositories;

use Modules\Core\Repositories\EloquentRepository;
use Modules\Inventory\Entities\Inventory;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;

class EloquentInventoryRepository extends EloquentRepository implements  InventoryRepository
{
    protected $allowedSearch = true;

    protected $allowedFilters = [
        'id',
        'code',
        'name'
    ];

    protected $allowedSorts = [
        'id',
        'code',
        'name',
        'available_items_count',
        'sold_items_count',
        'updated_at',
        'created_at'
    ];

    protected $allowedIncludes = [
        'items',
        'available_items',
        'sold_items'
    ];

    public function __construct(Inventory $model)
    {
        parent::__construct($model);
    }

    protected function allowedFilters(): array
    {
        return array_merge(parent::allowedFilters(), [
            AllowedFilter::exact('status', 'inventory_status')
        ]);
    }

    protected function allowedSorts(): array
    {
        return array_merge(parent::allowedSorts(), [
            AllowedSort::field('status', 'inventory_status')
        ]);
    }
}

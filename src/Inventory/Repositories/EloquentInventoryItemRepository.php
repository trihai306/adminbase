<?php

namespace Modules\Inventory\Repositories;

use Modules\Core\Repositories\EloquentRepository;
use Modules\Inventory\Entities\InventoryItem;

class EloquentInventoryItemRepository extends EloquentRepository implements  InventoryItemRepository
{
    protected $allowedSearch = true;

    protected $allowedFilters = [
        'id',
        'inventory_id',
        'importer_id',
        'status'
    ];

    protected $allowedSorts = [
        'id',
        'inventory_id',
        'importer_id',
        'status',
        'updated_at',
        'created_at'
    ];

    protected $allowedIncludes = [
        'inventory',
        'importer',
    ];

    public function __construct(InventoryItem $model)
    {
        parent::__construct($model);
    }

    public function getDeliveringInventoryItems($inventoryId, $quantity)
    {
        return $this->model->newQuery()
            ->where('inventory_id', $inventoryId)
            ->available()
            ->take($quantity)
            ->get();
    }
}

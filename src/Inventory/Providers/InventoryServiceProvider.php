<?php

namespace Modules\Inventory\Providers;

use Illuminate\Database\Eloquent\Factory;
use Modules\Core\Providers\ModuleServiceProvider;
use Modules\Inventory\Repositories\EloquentInventoryItemRepository;
use Modules\Inventory\Repositories\EloquentInventoryRepository;
use Modules\Inventory\Repositories\InventoryItemRepository;
use Modules\Inventory\Repositories\InventoryRepository;

class InventoryServiceProvider extends ModuleServiceProvider
{
    protected $moduleName = 'Inventory';

    protected $moduleNameLower = 'inventory';

    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
        $this->app->bind(InventoryRepository::class, EloquentInventoryRepository::class);
        $this->app->bind(InventoryItemRepository::class, EloquentInventoryItemRepository::class);
    }
}

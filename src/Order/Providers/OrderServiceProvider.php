<?php

namespace Modules\Order\Providers;

use Illuminate\Database\Eloquent\Factory;
use Modules\Core\Providers\ModuleServiceProvider;
use Modules\Order\Repositories\DeliveryInventoryItemRepository;
use Modules\Order\Repositories\EloquentDeliveryInventoryItemRepository;
use Modules\Order\Repositories\EloquentOrderItemRepository;
use Modules\Order\Repositories\EloquentOrderRepository;
use Modules\Order\Repositories\OrderItemRepository;
use Modules\Order\Repositories\OrderRepository;

class OrderServiceProvider extends ModuleServiceProvider
{
    protected $moduleName = 'Order';

    protected $moduleNameLower = 'order';

    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
        $this->app->register(EventServiceProvider::class);
        $this->app->bind(OrderRepository::class, EloquentOrderRepository::class);
        $this->app->bind(OrderItemRepository::class, EloquentOrderItemRepository::class);
        $this->app->bind(DeliveryInventoryItemRepository::class, EloquentDeliveryInventoryItemRepository::class);
    }
}

<?php

namespace Modules\Cart\Providers;

use Illuminate\Database\Eloquent\Factory;
use Modules\Cart\Repositories\CartRepository;
use Modules\Cart\Repositories\EloquentCartRepository;
use Modules\Core\Providers\ModuleServiceProvider;

class CartServiceProvider extends ModuleServiceProvider
{
    protected $moduleName = 'Cart';

    protected $moduleNameLower = 'cart';

    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
        $this->app->bind(CartRepository::class, EloquentCartRepository::class);
    }
}

<?php

namespace Modules\Shipping\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Modules\Core\Providers\ModuleServiceProvider;

class ShippingServiceProvider extends ModuleServiceProvider
{
    protected $moduleName = 'Shipping';

    protected $moduleNameLower = 'shipping';

    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
    }
}

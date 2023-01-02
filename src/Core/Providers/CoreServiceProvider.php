<?php

namespace Modules\Core\Providers;

use Illuminate\Http\Request;

class CoreServiceProvider extends ModuleServiceProvider
{
    protected $moduleName = 'Core';

    protected $moduleNameLower = 'core';

    public function boot()
    {
        parent::boot();
        $this->registerRequestMacros();
    }

    public function registerRequestMacros()
    {
        Request::macro('isShopApi', function () {
            return $this->is('api/shop/*');
        });

        Request::macro('isAdminApi', function () {
            return $this->is('api/admin/*');
        });
    }
}

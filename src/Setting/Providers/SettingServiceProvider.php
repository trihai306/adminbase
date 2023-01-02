<?php

namespace Modules\Setting\Providers;

use Illuminate\Database\Eloquent\Factory;
use Modules\Core\Providers\ModuleServiceProvider;
use Modules\Setting\Repositories\EloquentSettingRepository;
use Modules\Setting\Repositories\SettingRepository;

class SettingServiceProvider extends ModuleServiceProvider
{
    protected $moduleName = 'Setting';

    protected $moduleNameLower = 'setting';

    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
        $this->app->bind(SettingRepository::class, EloquentSettingRepository::class);
    }
}

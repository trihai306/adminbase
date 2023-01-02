<?php

namespace Modules\Media\Providers;

use Illuminate\Database\Eloquent\Factory;
use Modules\Core\Providers\ModuleServiceProvider;

class MediaServiceProvider extends ModuleServiceProvider
{
    protected $moduleName = 'Media';

    protected $moduleNameLower = 'media';

    public function boot()
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->loadMigrationsFrom(module_path($this->moduleName, 'Database/Migrations'));
    }

    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
    }
}

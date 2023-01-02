<?php

namespace Modules\Notification\Providers;

use Illuminate\Database\Eloquent\Factory;
use Modules\Core\Providers\ModuleServiceProvider;
use Modules\Notification\Repositories\EloquentNotificationRepository;
use Modules\Notification\Repositories\NotificationRepository;

class NotificationServiceProvider extends ModuleServiceProvider
{
    protected $moduleName = 'Notification';

    protected $moduleNameLower = 'notification';

    public function register()
    {
        $this->app->register(EventServiceProvider::class);
        $this->app->register(RouteServiceProvider::class);
        $this->app->register(BroadcastServiceProvider::class);
        $this->app->bind(NotificationRepository::class, EloquentNotificationRepository::class);
    }

    public function boot()
    {
        parent::boot();

        $this->registerViews();
    }

    public function registerViews()
    {
        $viewPath = resource_path('views/modules/' . $this->moduleNameLower);

        $sourcePath = module_path($this->moduleName, 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath
        ], ['views', $this->moduleNameLower . '-module-views']);

        $this->loadViewsFrom(array_merge($this->getPublishableViewPaths(), [$sourcePath]), $this->moduleNameLower);
    }

    private function getPublishableViewPaths(): array
    {
        $paths = [];
        foreach (\Config::get('view.paths') as $path) {
            if (is_dir($path . '/modules/' . $this->moduleNameLower)) {
                $paths[] = $path . '/modules/' . $this->moduleNameLower;
            }
        }
        return $paths;
    }
}

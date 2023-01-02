<?php

namespace Modules\Appearance\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Modules\Appearance\Repositories\EloquentMenuRepository;
use Modules\Appearance\Repositories\EloquentSlideRepository;
use Modules\Appearance\Repositories\EloquentSlugRepository;
use Modules\Appearance\Repositories\MenuRepository;
use Modules\Appearance\Repositories\SlideRepository;
use Modules\Appearance\Repositories\SlugRepository;
use Modules\Core\Providers\ModuleServiceProvider;

class AppearanceServiceProvider extends ModuleServiceProvider
{
    protected $moduleName = 'Appearance';

    protected $moduleNameLower = 'appearance';

    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
        $this->app->bind(SlugRepository::class, EloquentSlugRepository::class);
        $this->app->bind(SlideRepository::class, EloquentSlideRepository::class);
        $this->app->bind(MenuRepository::class, EloquentMenuRepository::class);
    }
}

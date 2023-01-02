<?php

namespace Modules\Catalog\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Catalog\Console\MigrateCategoryCommand;
use Modules\Catalog\Console\MigrateOptionCommand;
use Modules\Catalog\Console\MigrateProductCommand;

class CommandServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->commands(MigrateProductCommand::class);
        $this->commands(MigrateCategoryCommand::class);
        $this->commands(MigrateOptionCommand::class);
    }
}

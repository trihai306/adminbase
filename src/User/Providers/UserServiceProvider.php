<?php

namespace Modules\User\Providers;

use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Facades\Gate;
use Modules\Core\Providers\ModuleServiceProvider;
use Modules\User\Repositories\EloquentIdentifyProviderConnectionRepository;
use Modules\User\Repositories\EloquentIdentifyProviderRepository;
use Modules\User\Repositories\EloquentLoginHistoryRepository;
use Modules\User\Repositories\EloquentPermissionRepository;
use Modules\User\Repositories\EloquentRoleRepository;
use Modules\User\Repositories\EloquentTransactionRepository;
use Modules\User\Repositories\EloquentUserRepository;
use Modules\User\Repositories\EloquentWalletRepository;
use Modules\User\Repositories\EloquentWishlistRepository;
use Modules\User\Repositories\IdentifyProviderConnectionRepository;
use Modules\User\Repositories\IdentifyProviderRepository;
use Modules\User\Repositories\LoginHistoryRepository;
use Modules\User\Repositories\PermissionRepository;
use Modules\User\Repositories\RoleRepository;
use Modules\User\Repositories\TransactionRepository;
use Modules\User\Repositories\UserRepository;
use Modules\User\Repositories\WalletRepository;
use Modules\User\Repositories\WishlistRepository;

class UserServiceProvider extends ModuleServiceProvider
{
    protected $moduleName = 'User';

    protected $moduleNameLower = 'user';

    public function boot()
    {
        parent::boot();

        Gate::before(function ($user, $ability) {
            return $user->hasRole('super_admin') ? true : null;
        });
    }

    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
        $this->app->register(EventServiceProvider::class);
        $this->app->bind(UserRepository::class, EloquentUserRepository::class);
        $this->app->bind(IdentifyProviderRepository::class, EloquentIdentifyProviderRepository::class);
        $this->app->bind(IdentifyProviderConnectionRepository::class, EloquentIdentifyProviderConnectionRepository::class);
        $this->app->bind(WalletRepository::class, EloquentWalletRepository::class);
        $this->app->bind(RoleRepository::class, EloquentRoleRepository::class);
        $this->app->bind(PermissionRepository::class, EloquentPermissionRepository::class);
        $this->app->bind(TransactionRepository::class, EloquentTransactionRepository::class);
        $this->app->bind(WishlistRepository::class, EloquentWishlistRepository::class);
        $this->app->bind(LoginHistoryRepository::class, EloquentLoginHistoryRepository::class);
    }

    protected function registerConfig()
    {
        parent::registerConfig();

        config(['auth.providers.users.model' => \Modules\User\Entities\User::class]);

        $this->mergeConfigFrom(
            module_path($this->moduleName, 'Config/socials.php'), 'services'
        );
    }

    public function provides()
    {
        return [
            UserRepository::class
        ];
    }
}

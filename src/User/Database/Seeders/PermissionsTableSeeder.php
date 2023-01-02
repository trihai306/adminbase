<?php

namespace Modules\User\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Artisan;
use Modules\User\Enums\PermissionPermission;
use Modules\User\Enums\RolePermission;
use Modules\User\Enums\UserPermission;
use Spatie\Permission\Commands\CreatePermission;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        Model::unguard();

        $this->seed(UserPermission::class);
        $this->seed(PermissionPermission::class);
        $this->seed(RolePermission::class);
    }

    protected function seed($permission)
    {
        foreach ($permission::getValues() as $permission) {
            Artisan::call(CreatePermission::class, [
                'name' => $permission,
                'guard' => 'sanctum'
            ]);
        }
    }
}

<?php

namespace Modules\Payment\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Artisan;
use Modules\Payment\Enums\PaymentPermission;
use Spatie\Permission\Commands\CreatePermission;

class PermissionsDatabaseSeeder extends Seeder
{
    public function run()
    {
        Model::unguard();

        $this->seed(PaymentPermission::class);
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

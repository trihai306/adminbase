<?php

namespace Modules\User\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

class RolesTableTableSeeder extends Seeder
{
    public function run()
    {
        Model::unguard();

        Role::updateOrCreate([
            'name' => 'super_admin',
            'display_name' => 'Siêu quản trị',
            'guard_name' => 'sanctum',
            'is_system' => true
        ]);
    }
}

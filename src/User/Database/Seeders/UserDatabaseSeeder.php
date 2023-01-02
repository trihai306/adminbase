<?php

namespace Modules\User\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class UserDatabaseSeeder extends Seeder
{
    public function run()
    {
        Model::unguard();

        $this->call(PermissionsTableSeeder::class);
        $this->call(RolesTableTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(IdentifyProvidersTableSeeder::class);
    }
}

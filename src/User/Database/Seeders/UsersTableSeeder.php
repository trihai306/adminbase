<?php

namespace Modules\User\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Modules\User\Entities\User;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        Model::unguard();

        $user = User::create([
            'username' => 'admin',
            'email' => 'admin@muakey.com',
            'password' => 'Muakey@123',
            'is_admin' => true
        ]);

        $user->assignRole('super_admin');
    }
}

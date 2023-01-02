<?php

namespace Modules\Payment\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class PaymentDatabaseSeeder extends Seeder
{
    public function run()
    {
        Model::unguard();

        $this->call(PermissionsDatabaseSeeder::class);
        $this->call(PaymentMethodsTableSeeder::class);
        $this->call(PaymentsTableSeeder::class);
    }
}

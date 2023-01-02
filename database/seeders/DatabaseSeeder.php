<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Catalog\Database\Seeders\CatalogDatabaseSeeder;
use Modules\Order\Database\Seeders\OrdersTableSeeder;
use Modules\Payment\Database\Seeders\PaymentDatabaseSeeder;
use Modules\User\Database\Seeders\UserDatabaseSeeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(UserDatabaseSeeder::class);
    }
}

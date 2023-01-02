<?php

namespace Modules\Order\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Order\Entities\Order;

class OrdersTableSeeder extends Seeder
{
    public function run()
    {
        Model::unguard();

       Order::factory(10)
           ->hasItems(5)
           ->create();
    }
}

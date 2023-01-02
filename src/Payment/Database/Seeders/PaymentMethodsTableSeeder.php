<?php

namespace Modules\Payment\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Payment\Entities\PaymentMethod;

class PaymentMethodsTableSeeder extends Seeder
{
    public function run()
    {
        Model::unguard();

        PaymentMethod::factory(3)->create();
    }
}

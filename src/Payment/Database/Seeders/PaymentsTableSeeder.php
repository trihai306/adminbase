<?php

namespace Modules\Payment\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Payment\Entities\Payment;

class PaymentsTableSeeder extends Seeder
{
    public function run()
    {
        Model::unguard();

        Payment::factory(100)->create();
    }
}

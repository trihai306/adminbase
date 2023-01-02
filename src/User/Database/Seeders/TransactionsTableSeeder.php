<?php

namespace Modules\User\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Modules\User\Entities\Transaction;

class TransactionsTableSeeder extends Seeder
{
    public function run()
    {
        Model::unguard();

        if (!App::isProduction()) {
            Transaction::factory(100)->create();
        }
    }
}

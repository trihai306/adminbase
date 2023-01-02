<?php

namespace Modules\Catalog\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Catalog\Entities\Option;
use Modules\Catalog\Entities\OptionValue;

class OptionsTableSeeder extends Seeder
{
    public function run()
    {
        Model::unguard();

        Option::factory(4)->create();
    }
}

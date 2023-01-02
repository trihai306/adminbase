<?php

namespace Modules\Catalog\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Catalog\Entities\Collection;

class CollectionsTableSeeder extends Seeder
{
    public function run()
    {
        Model::unguard();

        Collection::factory(5)->create();
    }
}

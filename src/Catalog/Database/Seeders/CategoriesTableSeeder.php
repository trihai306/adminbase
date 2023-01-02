<?php

namespace Modules\Catalog\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Catalog\Entities\Category;

class CategoriesTableSeeder extends Seeder
{
    public function run()
    {
        Model::unguard();

        Category::factory(10)->create();
    }
}

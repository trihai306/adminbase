<?php

namespace Modules\Catalog\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Catalog\Entities\Product;

class ProductsTableSeeder extends Seeder
{
    public function run()
    {
        Model::unguard();

        Product::factory(100)->create();
    }
}

<?php

namespace Modules\Catalog\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class CatalogDatabaseSeeder extends Seeder
{
    public function run()
    {
        Model::unguard();

        $this->call(CategoriesTableSeeder::class);
        $this->call(CollectionsTableSeeder::class);
        $this->call(OptionsTableSeeder::class);
        $this->call(ProductsTableSeeder::class);
        $this->call(ReviewsTableSeeder::class);
    }
}

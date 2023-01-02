<?php

namespace Modules\Catalog\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Catalog\Entities\Review;

class ReviewsTableSeeder extends Seeder
{
    public function run()
    {
        Model::unguard();

        Review::factory(100)->create();
    }
}

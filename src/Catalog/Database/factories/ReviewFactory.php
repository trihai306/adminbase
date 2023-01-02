<?php
namespace Modules\Catalog\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Catalog\Entities\Product;
use Modules\User\Entities\User;

class ReviewFactory extends Factory
{
    protected $model = \Modules\Catalog\Entities\Review::class;

    public function definition()
    {
        return [
            'reviewer_id' => User::inRandomOrder()->first()->id,
            'product_id' => Product::inRandomOrder()->first()->id,
            'parent_id' => null,
            'rating' => $this->faker->numberBetween(0, 5),
            'comment' => $this->faker->sentence
        ];
    }
}


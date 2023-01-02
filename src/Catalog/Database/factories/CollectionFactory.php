<?php
namespace Modules\Catalog\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CollectionFactory extends Factory
{
    protected $model = \Modules\Catalog\Entities\Collection::class;

    public function definition()
    {
        $name = $this->faker->unique()->sentence(rand(1, 3));

        return [
            'code' => Str::slug($name),
            'name' => $name
        ];
    }
}


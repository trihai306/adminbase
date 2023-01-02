<?php
namespace Modules\Catalog\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Modules\Catalog\Entities\Category;

class CategoryFactory extends Factory
{
    protected $model = Category::class;
    static $depth = 0;

    public function definition()
    {
        $name = $this->faker->unique()->sentence(
            $this->faker->numberBetween(2, 6)
        );

        return [
            'parent_id' => null,
            'code' => Str::slug($name),
            'name' => $name,
            'image' => null
        ];
    }

    public function configure()
    {
        return parent::configure()->afterCreating(function (Category $category) {
            static::$depth++;
            if ($this->faker->boolean && static::$depth < 4) {
                Category::factory($this->faker->numberBetween(1, 10))
                    ->create(['parent_id' => $category->id]);
            }
        });
    }
}


<?php
namespace Modules\Catalog\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class OptionValueFactory extends Factory
{
    protected $model = \Modules\Catalog\Entities\OptionValue::class;

    public function definition()
    {
        $name = $this->faker->unique()->sentence;

        return [
            'code' => Str::slug($name),
            'name' => $name,
            'image' => null,
            'description' => $this->faker->paragraph
        ];
    }
}


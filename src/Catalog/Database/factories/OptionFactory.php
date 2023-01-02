<?php
namespace Modules\Catalog\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Modules\Catalog\Entities\Option;
use Modules\Catalog\Entities\OptionValue;

class OptionFactory extends Factory
{
    protected $model = \Modules\Catalog\Entities\Option::class;

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

    public function configure()
    {
        return parent::configure()->afterCreating(function (Option $option) {
            OptionValue::factory($this->faker->numberBetween(1, 5))->create([
                'option_id' => $option->id
            ]);
        });
    }
}


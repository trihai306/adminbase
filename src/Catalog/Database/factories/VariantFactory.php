<?php
namespace Modules\Catalog\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Catalog\Enums\OrderType;

class VariantFactory extends Factory
{
    protected $model = \Modules\Catalog\Entities\Variant::class;

    public function definition()
    {
        $name = $this->faker->unique()->sentence(
            $this->faker->numberBetween(3, 10)
        );

        return [
            'product_id' => null,
            'code' => null,
            'name' => $name,
            'image' => null,
            'price' => $this->faker->numberBetween(1, 1000) * 1000,
            'discount_price' => null,
            'order_type' => $this->faker->randomElement(OrderType::getValues()),
            'is_default' => $this->faker->boolean
        ];
    }
}


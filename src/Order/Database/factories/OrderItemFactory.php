<?php
namespace Modules\Order\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Catalog\Entities\Variant;

class OrderItemFactory extends Factory
{
    protected $model = \Modules\Order\Entities\OrderItem::class;

    public function definition()
    {
        $variant = Variant::inRandomOrder()->first();

        return [
            'order_id' => null,
            'variant_id' => $variant->id,
            'code' => $variant->code,
            'name' => $variant->name,
            'image' => $variant->image,
            'price' => $variant->sale_price,
            'quantity' => $this->faker->numberBetween(1, 10),
        ];
    }
}


<?php
namespace Modules\Order\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Order\Enums\OrderStatus;
use Modules\User\Entities\User;

class OrderFactory extends Factory
{
    protected $model = \Modules\Order\Entities\Order::class;

    public function definition()
    {
        return [
            'buyer_id' => User::inRandomOrder()->first()->id,
            'total' => 0,
            'status' => $this->faker->randomElement(OrderStatus::getValues())
        ];
    }
}


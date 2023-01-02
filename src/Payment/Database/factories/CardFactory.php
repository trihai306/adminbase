<?php
namespace Modules\Payment\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Payment\Enums\CardStatus;
use Modules\Payment\Enums\CardType;

class CardFactory extends Factory
{
    protected $model = \Modules\Payment\Entities\Card::class;

    public function definition()
    {
        return [
            'payment_method_id' => null,
            'type' => $this->faker->randomElement(CardType::getValues()),
            'name' => $this->faker->sentence,
            'image' => null,
            'values' => $this->faker->randomElements([
                10000,
                20000,
                50000,
                100000,
                200000,
                500000
            ]),
            'discount_rate' => $this->faker->numberBetween(0, 100),
            'index' => $this->faker->numberBetween(0, 100),
            'status' => $this->faker->randomElement(CardStatus::getValues())
        ];
    }
}


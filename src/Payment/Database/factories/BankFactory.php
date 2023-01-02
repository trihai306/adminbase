<?php
namespace Modules\Payment\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Payment\Enums\BankStatus;

class BankFactory extends Factory
{
    protected $model = \Modules\Payment\Entities\Bank::class;

    public function definition()
    {
        return [
            'payment_method_id' => null,
            'name' => $this->faker->sentence,
            'image' => null,
            'account_name' => $this->faker->name,
            'account_number' => $this->faker->creditCardNumber,
            'branch' => $this->faker->sentence(2),
            'discount_rate' => $this->faker->numberBetween(0, 100),
            'index' => $this->faker->numberBetween(0, 100),
            'status' => $this->faker->randomElement(BankStatus::getValues())
        ];
    }
}


<?php
namespace Modules\User\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\User\Entities\User;

class TransactionFactory extends Factory
{
    protected $model = \Modules\User\Entities\Transaction::class;

    public function definition()
    {
        $user = User::inRandomOrder()->first();
        $amount = $this->faker->numberBetween(1, 1000) * 1000;

        return [
            'user_id' => $user->id,
            'amount' => $this->faker->boolean ? $amount : -$amount,
            'balance' => $user->wallet->balance,
            'content' => $this->faker->sentence
        ];
    }
}


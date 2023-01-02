<?php
namespace Modules\User\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    protected $model = \Modules\User\Entities\User::class;

    public function definition(): array
    {
        return [
            'username' => $this->faker->unique()->userName,
            'password' => '123456',
            'full_name' => $this->faker->name,
            'email' => $this->faker->unique()->email,
            'phone' => $this->faker->phoneNumber,
            'birthday' => $this->faker->date
        ];
    }
}


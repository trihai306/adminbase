<?php
namespace Modules\Payment\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Payment\Entities\PaymentMethod;
use Modules\Payment\Enums\PaymentMethodType;
use Modules\Payment\Enums\PaymentStatus;
use Modules\Payment\Enums\PaymentType;
use Modules\User\Entities\User;

class PaymentFactory extends Factory
{
    protected $model = \Modules\Payment\Entities\Payment::class;

    public function definition()
    {
        $user = User::inRandomOrder()->first();
        $paymentMethod = PaymentMethod::inRandomOrder()->first();

        return [
            'payer_id' => $user->id,
            'type' => $this->faker->randomElement(PaymentType::getValues()),
            'method_id' => $paymentMethod->id,
            'method_type' => $paymentMethod->type,
            'amount' => $this->faker->numberBetween(1, 1000) * 1000,
            'discount_rate' => $this->faker->numberBetween(0, 100),
            'verifier_id' => null,
            'verified_at' => null,
            'feed_back' => null,
            'status' => $this->faker->randomElement(PaymentStatus::getValues())
        ];
    }
}


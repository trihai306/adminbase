<?php
namespace Modules\Payment\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Modules\Payment\Entities\Bank;
use Modules\Payment\Entities\Card;
use Modules\Payment\Entities\PaymentMethod;
use Modules\Payment\Enums\PaymentMethodStatus;
use Modules\Payment\Enums\PaymentMethodType;

class PaymentMethodFactory extends Factory
{
    protected $model = \Modules\Payment\Entities\PaymentMethod::class;

    public function definition()
    {
        $name = $this->faker->unique()->sentence;

        return [
            'type' => $this->faker->randomElement(PaymentMethodType::getValues()),
            'code' => Str::slug($name),
            'name' => $name,
            'image' => null,
            'description' => $this->faker->paragraph,
            'config' => null,
            'status' => $this->faker->randomElement(PaymentMethodStatus::getValues())
        ];
    }

    public function configure()
    {
        return parent::configure()->afterCreating(function (PaymentMethod $paymentMethod) {
            if ($paymentMethod->type == PaymentMethodType::BANK_TRANSFER) {
                Bank::factory($this->faker->numberBetween(3, 5))->create([
                    'payment_method_id' => $paymentMethod->id
                ]);
            } else {
                Card::factory($this->faker->numberBetween(3, 5))->create([
                    'payment_method_id' => $paymentMethod->id
                ]);
            }
        });
    }
}


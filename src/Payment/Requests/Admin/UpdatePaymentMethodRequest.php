<?php

namespace Modules\Payment\Requests\Admin;

use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Validation\Rules\Exists;
use Illuminate\Validation\Rules\Unique;
use Modules\Core\Requests\FormRequest;
use Modules\Media\Enums\MediaType;
use Modules\Media\Rules\MediaFile;
use Modules\Payment\Entities\Bank;
use Modules\Payment\Entities\Card;
use Modules\Payment\Entities\PaymentMethod;
use Modules\Payment\Enums\BankStatus;
use Modules\Payment\Enums\CardStatus;
use Modules\Payment\Enums\CardType;
use Modules\Payment\Enums\PaymentMethodStatus;

class UpdatePaymentMethodRequest extends FormRequest
{
    public function rules(): array
    {
        $paymentMethodId = $this->route('payment_method');

        return [
            'code' => [
                'filled',
                (new Unique(PaymentMethod::class))->ignore($paymentMethodId)
            ],
            'name' => 'filled',
            'image' => [
                'nullable',
                new MediaFile(MediaType::IMAGE)
            ],
            'description' => 'nullable',
            'config' => 'array',
            'banks' => 'array',
            'banks.*.id' => [
                (new Exists(Bank::class))
                    ->where('payment_method_id', $paymentMethodId)
            ],
            'banks.*.name' => 'filled',
            'banks.*.image' => 'nullable',
            'banks.*.account_name' => 'filled',
            'banks.*.account_number' => 'filled',
            'banks.*.branch' => 'filled',
            'banks.*.discount_rate' => [
                'filled',
                'integer',
                'min:0',
                'max:100'
            ],
            'banks.*.status' => [
                'filled',
                new EnumValue(BankStatus::class)
            ],
            'cards' => 'array',
            'cards.*.id' => [
                (new Exists(Card::class))
                    ->where('payment_method_id', $paymentMethodId)
            ],
            'cards.*.type' => [
                'filled',
                new EnumValue(CardType::class)
            ],
            'cards.*.name' => 'filled',
            'cards.*.image' => 'nullable',
            'cards.*.values' => [
                'filled',
                'array'
            ],
            'cards.*.values.*' => 'integer',
            'cards.*.discount_rate' => 'filled',
            'cards.*.status' => [
                'filled',
                new EnumValue(CardStatus::class)
            ],
            'checkout_enabled' => 'boolean',
            'recharge_enabled' => 'boolean',
            'status' => [
                'filled',
                new EnumValue(PaymentMethodStatus::class)
            ],
        ];
    }
}

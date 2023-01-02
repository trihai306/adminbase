<?php

namespace Modules\Payment\Requests\Admin;

use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Validation\Rules\Unique;
use Modules\Core\Requests\FormRequest;
use Modules\Media\Enums\MediaType;
use Modules\Media\Rules\MediaFile;
use Modules\Payment\Entities\PaymentMethod;
use Modules\Payment\Enums\BankStatus;
use Modules\Payment\Enums\CardStatus;
use Modules\Payment\Enums\CardType;
use Modules\Payment\Enums\PaymentMethodStatus;
use Modules\Payment\Enums\PaymentMethodType;

class StorePaymentMethodRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'type' => [
                'required',
                new EnumValue(PaymentMethodType::class)
            ],
            'code' => [
                'required',
                new Unique(PaymentMethod::class)
            ],
            'name' => 'required',
            'image' => [
                'nullable',
                new MediaFile(MediaType::IMAGE)
            ],
            'description' => 'nullable',
            'config' => 'array',
            'banks' => 'array',
            'banks.*.name' => 'required_with:banks',
            'banks.*.image' => 'nullable',
            'banks.*.account_name' => 'required_with:banks',
            'banks.*.account_number' => 'required_with:banks',
            'banks.*.branch' => 'required_with:banks',
            'banks.*.discount_rate' => [
                'required_with:banks',
                'integer',
                'min:0',
                'max:100'
            ],
            'banks.*.status' => [
                'required_with:banks',
                new EnumValue(BankStatus::class)
            ],
            'cards' => 'array',
            'cards.*.type' => [
                'required_with:cards',
                new EnumValue(CardType::class)
            ],
            'cards.*.name' => 'required_with:cards',
            'cards.*.image' => 'nullable',
            'cards.*.values' => [
                'required_with:cards',
                'array'
            ],
            'cards.*.values.*' => 'integer',
            'cards.*.discount_rate' => 'required_with:cards',
            'cards.*.status' => [
                'required_with:cards',
                new EnumValue(CardStatus::class)
            ],
            'checkout_enabled' => 'boolean',
            'recharge_enabled' => 'boolean',
            'status' => [
                'required',
                new EnumValue(PaymentMethodStatus::class)
            ],
        ];
    }
}

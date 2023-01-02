<?php

namespace Modules\Payment\Requests\Admin;

use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Validation\Rules\Exists;
use Modules\Core\Requests\FormRequest;
use Modules\Payment\Entities\PaymentMethod;
use Modules\Payment\Enums\CardType;
use Modules\Payment\Enums\PaymentMethodType;

class StoreCardRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'payment_method_id' => [
                'required',
                (new Exists(PaymentMethod::class, 'id'))
                    ->where('type', PaymentMethodType::CARD)
            ],
            'type' => [
                'required',
                new EnumValue(CardType::class)
            ],
            'name' => 'required',
            'image' => 'nullable',
            'values' => [
                'required',
                'array'
            ],
            'values.*' => 'integer',
            'discount_rate' => 'required',
            'enabled' => [
                'required',
                'boolean'
            ],
        ];
    }
}

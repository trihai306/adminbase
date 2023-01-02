<?php

namespace Modules\Payment\Requests\Admin;

use BenSampo\Enum\Rules\EnumValue;
use Modules\Core\Requests\FormRequest;
use Modules\Payment\Enums\CardType;

class UpdateCardRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'type' => [
                'filled',
                new EnumValue(CardType::class)
            ],
            'name' => 'filled',
            'image' => 'nullable',
            'values' => [
                'filled',
                'array'
            ],
            'values.*' => 'integer',
            'discount_rate' => 'filled',
            'enabled' => [
                'filled',
                'boolean'
            ],
        ];
    }
}

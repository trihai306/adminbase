<?php

namespace Modules\Catalog\Requests\Admin;

use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Validation\Rules\Unique;
use Modules\Catalog\Entities\Attribute;
use Modules\Catalog\Enums\AttributeType;
use Modules\Core\Requests\FormRequest;

class UpdateAttributeRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'code' => [
                'filled',
                (new Unique(Attribute::class))
                    ->ignore($this->route('attribute'))
            ],
            'name' => 'filled',
            'type' => [
                'filled',
                new EnumValue(AttributeType::class, false)
            ]
        ];
    }
}

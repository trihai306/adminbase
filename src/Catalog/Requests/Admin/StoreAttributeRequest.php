<?php

namespace Modules\Catalog\Requests\Admin;

use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Validation\Rules\Unique;
use Modules\Catalog\Entities\Attribute;
use Modules\Catalog\Enums\AttributeType;
use Modules\Core\Requests\FormRequest;

class StoreAttributeRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'code' => [
                'required',
                new Unique(Attribute::class)
            ],
            'name' => 'required',
            'type' => [
                'required',
                new EnumValue(AttributeType::class, false)
            ]
        ];
    }
}

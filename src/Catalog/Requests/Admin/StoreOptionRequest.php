<?php

namespace Modules\Catalog\Requests\Admin;

use Illuminate\Validation\Rules\Unique;
use Modules\Catalog\Entities\Option;
use Modules\Catalog\Entities\OptionValue;
use Modules\Core\Requests\FormRequest;
use Modules\Media\Enums\MediaType;
use Modules\Media\Rules\MediaFile;

class StoreOptionRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'code' => [
                'required',
                new Unique(Option::class)
            ],
            'name' => 'required',
            'image' => [
                'nullable',
                new MediaFile(MediaType::IMAGE)
            ],
            'description' => 'nullable',
            'values' => [
                'required',
                'array'
            ],
            'values.*' => 'array',
            'values.*.code' => [
                'required',
                new Unique(OptionValue::class, 'code')
            ],
            'values.*.name' => [
                'required',
            ],
            'values.*.image' => [
                'nullable',
                new MediaFile(MediaType::IMAGE)
            ],
            'values.*.description' => 'nullable',
        ];
    }
}

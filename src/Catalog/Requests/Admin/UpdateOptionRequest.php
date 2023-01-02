<?php

namespace Modules\Catalog\Requests\Admin;

use Illuminate\Validation\Rules\Exists;
use Illuminate\Validation\Rules\Unique;
use Modules\Catalog\Entities\Option;
use Modules\Catalog\Entities\OptionValue;
use Modules\Core\Requests\FormRequest;
use Modules\Media\Enums\MediaType;
use Modules\Media\Rules\MediaFile;

class UpdateOptionRequest extends FormRequest
{
    public function rules(): array
    {
        $rules = [
            'code' => [
                'filled',
                (new Unique(Option::class))
                    ->ignore($this->route('option'))
            ],
            'name' => 'filled',
            'image' => [
                'nullable',
                new MediaFile(MediaType::IMAGE)
            ],
            'values.*' => 'array',
            'value.*.id' => [
                'filled',
                new Exists(OptionValue::class)
            ],
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

        if (is_array($this->input('values'))) {
            foreach ($this->input('values') as $key => $value) {
                if (empty($value['id'])) {
                    $rules["values.$key.code"] = [
                        'required',
                        new Unique(OptionValue::class, 'code')
                    ];
                } else {
                    $rules["values.$key.code"] = [
                        'required',
                        (new Unique(OptionValue::class, 'code'))
                            ->ignore($value['id'])
                    ];
                }
            }
        }

        return $rules;
    }
}

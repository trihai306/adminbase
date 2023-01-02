<?php

namespace Modules\Media\Requests;

use BenSampo\Enum\Rules\EnumValue;
use Modules\Core\Requests\FormRequest;
use Modules\Media\Enums\MediaType;

class StoreFileRequest extends FormRequest
{
    public function rules(): array
    {
        $rules = [
            'type' => [
                'required',
                new EnumValue(MediaType::class)
            ],
            'file' => [
                'required',
                'file'
            ]
        ];

        if ($this->input('type') === MediaType::IMAGE) {
            $rules['file'][] = 'image';
        }

        return $rules;
    }
}

<?php

namespace Modules\Catalog\Requests\Admin;

use Modules\Core\Requests\FormRequest;
use Modules\Media\Rules\MediaFile;

class UpdateBrandRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'logo' => [
                'nullable',
                new MediaFile(MediaType::IMAGE)
            ],
            'name' => 'filled'
        ];
    }
}

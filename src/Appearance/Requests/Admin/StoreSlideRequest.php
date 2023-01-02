<?php

namespace Modules\Appearance\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Unique;
use Modules\Appearance\Entities\Slide;
use Modules\Media\Enums\MediaType;
use Modules\Media\Rules\MediaFile;

class StoreSlideRequest extends FormRequest
{
    public function rules()
    {
        return [
            'code' => [
                'required',
                new Unique(Slide::class)
            ],
            'name' => 'required',
            'items' => 'array',
            'items.*.image' => [
                'required',
                new MediaFile(MediaType::IMAGE)
            ],
            'items.*.url' => [
                'nullable',
                'url'
            ]
        ];
    }
}

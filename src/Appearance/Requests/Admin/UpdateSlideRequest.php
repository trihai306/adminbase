<?php

namespace Modules\Appearance\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Exists;
use Illuminate\Validation\Rules\Unique;
use Modules\Appearance\Entities\Slide;
use Modules\Appearance\Entities\SlideItem;
use Modules\Media\Enums\MediaType;
use Modules\Media\Rules\MediaFile;

class UpdateSlideRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'code' => [
                'filled',
                (new Unique(Slide::class))
                    ->ignore($this->route('slide'))
            ],
            'name' => 'filled',
            'items' => 'array',
            'items.*.id' => new Exists(SlideItem::class),
            'items.*.image' => [
                'filled',
                new MediaFile(MediaType::IMAGE)
            ],
            'items.*.url' => [
                'nullable',
                'url'
            ]
        ];
    }
}

<?php

namespace Modules\Catalog\Requests\Admin;

use Illuminate\Validation\Rules\Unique;
use Modules\Appearance\Entities\Slug;
use Modules\Catalog\Entities\Collection;
use Modules\Core\Requests\FormRequest;
use Modules\Media\Enums\MediaType;
use Modules\Media\Rules\MediaFile;

class StoreCollectionRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'code' => [
                'filled',
                new Unique(Collection::class)
            ],
            'name' => 'required',
            'slug' => [
                'required',
                new Unique(Slug::class)
            ],
            'image' => [
                'nullable',
                new MediaFile(MediaType::IMAGE)
            ]
        ];
    }
}

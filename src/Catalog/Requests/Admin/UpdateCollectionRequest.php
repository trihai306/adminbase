<?php

namespace Modules\Catalog\Requests\Admin;

use Illuminate\Validation\Rules\Unique;
use Modules\Appearance\Entities\Slug;
use Modules\Catalog\Entities\Collection;
use Modules\Core\Requests\FormRequest;
use Modules\Media\Enums\MediaType;
use Modules\Media\Rules\MediaFile;

class UpdateCollectionRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'code' => [
                'filled',
                (new Unique(Collection::class))
                    ->ignore($this->route('collection'))
            ],
            'name' => 'filled',
            'slug' => [
                'filled',
                (new Unique(Slug::class))
                    ->where('slugable_type', Collection::class)
                    ->ignore($this->route('collection'), 'slugable_id')
            ],
            'image' => [
                'nullable',
                new MediaFile(MediaType::IMAGE)
            ]
        ];
    }
}

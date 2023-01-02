<?php

namespace Modules\Catalog\Requests\Admin;

use Illuminate\Validation\Rules\Exists;
use Illuminate\Validation\Rules\Unique;
use Modules\Appearance\Entities\Slug;
use Modules\Catalog\Entities\Attribute;
use Modules\Catalog\Entities\Category;
use Modules\Catalog\Entities\CategoryTag;
use Modules\Core\Requests\FormRequest;
use Modules\Media\Enums\MediaType;
use Modules\Media\Rules\MediaFile;

class StoreCategoryRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'parent_id' => [
                'nullable',
                new Exists(Category::class, 'id')
            ],
            'code' => [
                'required',
                new Unique(Category::class)
            ],
            'name' => 'required',
            'slug' => [
                'required',
                new Unique(Slug::class)
            ],
            'icon' => [
                'nullable',
                new MediaFile(MediaType::IMAGE)
            ],
            'image' => [
                'nullable',
                new MediaFile(MediaType::IMAGE)
            ],
            'children_tag_ids' => [
                'array',
                new Exists(CategoryTag::class, 'id')
            ],
            'tag_ids' => [
                'array',
                new Exists(CategoryTag::class, 'id')
            ]
        ];
    }
}

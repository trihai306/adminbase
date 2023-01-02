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

class UpdateCategoryRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'parent_id' => [
                'nullable',
                new Exists(Category::class, 'id')
            ],
            'code' => [
                'filled',
                (new Unique(Category::class))
                    ->ignore($this->route('category'))
            ],
            'name' => 'filled',
            'slug' => [
                'filled',
                (new Unique(Slug::class))
                    ->where('slugable_type', Category::class)
                    ->ignore($this->route('category'), 'slugable_id')
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

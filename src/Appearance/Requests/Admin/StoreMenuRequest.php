<?php

namespace Modules\Appearance\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Unique;
use Modules\Appearance\Entities\Menu;

class StoreMenuRequest extends FormRequest
{
    public function rules()
    {
        return [
            'code' => [
                'required',
                new Unique(Menu::class)
            ],
            'name' => 'required',
            'items' => 'array',
            'items.*.icon' => 'nullable',
            'items.*.name' => 'required',
            'items.*.url' => [
                'nullable',
                'url'
            ]
        ];
    }
}

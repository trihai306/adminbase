<?php

namespace Modules\Appearance\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Exists;
use Illuminate\Validation\Rules\Unique;
use Modules\Appearance\Entities\Menu;
use Modules\Appearance\Entities\MenuItem;

class UpdateMenuRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'code' => [
                'filled',
                (new Unique(Menu::class))
                    ->ignore($this->route('menu'))
            ],
            'name' => 'filled',
            'items' => 'array',
            'items.*.id' => new Exists(MenuItem::class),
            'items.*.icon' => 'nullable',
            'items.*.name' => 'filled',
            'items.*.url' => [
                'nullable',
                'url'
            ]
        ];
    }
}

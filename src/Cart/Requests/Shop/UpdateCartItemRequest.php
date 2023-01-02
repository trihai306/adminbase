<?php

namespace Modules\Cart\Requests\Shop;

use Illuminate\Validation\Rules\Exists;
use Modules\Catalog\Entities\Variant;
use Modules\Core\Requests\FormRequest;

class UpdateCartItemRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'quantity' => [
                'filled',
                'integer',
                'min:0'
            ]
        ];
    }
}

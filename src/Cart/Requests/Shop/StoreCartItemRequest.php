<?php

namespace Modules\Cart\Requests\Shop;

use Illuminate\Validation\Rules\Exists;
use Modules\Catalog\Entities\Variant;
use Modules\Core\Requests\FormRequest;

class StoreCartItemRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'variant_id' => [
                'required',
                new Exists(Variant::class, 'id')
            ],
            'quantity' => [
                'required',
                'integer',
                'min:0'
            ]
        ];
    }
}

<?php

namespace Modules\User\Requests\Shop;

use Illuminate\Validation\Rules\Exists;
use Modules\Catalog\Entities\Product;
use Modules\Core\Requests\FormRequest;

class StoreWishlistRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'product_id' => [
                'required',
                new Exists(Product::class, 'id')
            ]
        ];
    }
}

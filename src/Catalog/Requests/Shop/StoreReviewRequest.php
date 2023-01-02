<?php

namespace Modules\Catalog\Requests\Shop;

use Illuminate\Validation\Rules\Exists;
use Modules\Catalog\Entities\Product;
use Modules\Catalog\Entities\Review;
use Modules\Core\Requests\FormRequest;
use Modules\Order\Entities\OrderItem;

class StoreReviewRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'parent_id' => [
                'nullable',
                new Exists(Review::class, 'id')
            ],
            'product_id' => [
                'required',
                new Exists(Product::class, 'id')
            ],
            'order_item_id' => [
                'required_with:rating',
                new Exists(OrderItem::class, 'id')
            ],
            'rating' => [
                'integer',
                'between:0,5'
            ],
            'comment' => [
                'required',
                'max:255'
            ]
        ];
    }
}

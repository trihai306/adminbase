<?php

namespace Modules\Cart\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class CartItemResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'variant_id' => $this->variant_id,
            'code' => $this->code,
            'name' => $this->name,
            'image' => $this->image,
            'price' => $this->price,
            'discount_price' => $this->discount_price,
            'sale_price' => $this->sale_price,
            'quantity' => $this->quantity,
            'total' => $this->total,
            'order_type' => $this->order_type
        ];
    }
}

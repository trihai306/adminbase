<?php

namespace Modules\Catalog\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class PromotionResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'name' => $this->name,
            'scope_type' => $this->scope_type,
            'products' => $this->whenLoaded('products', function () {
                return ProductResource::collection($this->products);
            }),
            'product_ids' => $this->whenLoaded('product_ids', function () {
                return $this->product_ids->pluck('id');
            }),
            'action_type' => $this->action_type,
            'action_amount' => $this->action_amount,
            'start_at' => $this->start_at,
            'end_at' => $this->end_at,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}

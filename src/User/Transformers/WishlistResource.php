<?php

namespace Modules\User\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Catalog\Transformers\ProductResource;

class WishlistResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'product_id' => $this->product_id,
            'product' => $this->whenLoaded('product', function () {
                return new ProductResource($this->product);
            }),
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at
        ];
    }
}

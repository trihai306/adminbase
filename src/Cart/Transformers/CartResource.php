<?php

namespace Modules\Cart\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'items' => CartItemResource::collection(
                $this->items->values()
            ),
            'total' => $this->total,
        ];
    }
}

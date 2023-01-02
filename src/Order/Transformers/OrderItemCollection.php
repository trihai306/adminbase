<?php

namespace Modules\Order\Transformers;

use Illuminate\Http\Resources\Json\ResourceCollection;

class OrderItemCollection extends ResourceCollection
{
    public function toArray($request): array
    {
        return [
            'data' => OrderItemResource::collection($this->collection)
        ];
    }
}

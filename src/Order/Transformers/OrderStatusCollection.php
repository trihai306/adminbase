<?php

namespace Modules\Order\Transformers;

use Illuminate\Http\Resources\Json\ResourceCollection;

class OrderStatusCollection extends ResourceCollection
{
    public function toArray($request): array
    {
        return [
            'data' => OrderStatusResource::collection($this->collection)
        ];
    }
}

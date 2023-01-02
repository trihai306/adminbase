<?php

namespace Modules\Order\Transformers;

use Illuminate\Http\Resources\Json\ResourceCollection;

class OrderCollection extends ResourceCollection
{
    public function toArray($request): array
    {
        return [
            'data' => OrderResource::collection($this->collection)
        ];
    }
}

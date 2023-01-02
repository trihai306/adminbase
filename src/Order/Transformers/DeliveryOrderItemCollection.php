<?php

namespace Modules\Order\Transformers;

use Illuminate\Http\Resources\Json\ResourceCollection;

class DeliveryOrderItemCollection extends ResourceCollection
{
    public function toArray($request): array
    {
        return [
            'data' => DeliveryInventoryItemResource::collection($this->collection)
        ];
    }
}

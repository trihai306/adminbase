<?php

namespace Modules\Inventory\Transformers;

use Illuminate\Http\Resources\Json\ResourceCollection;

class InventoryItemCollection extends ResourceCollection
{
    public function toArray($request): array
    {
        return [
            'data' => InventoryItemResource::collection($this->collection)
        ];
    }
}

<?php

namespace Modules\Inventory\Transformers;

use Illuminate\Http\Resources\Json\ResourceCollection;

class InventoryCollection extends ResourceCollection
{
    public function toArray($request): array
    {
        return [
            'data' => InventoryResource::collection($this->collection)
        ];
    }
}

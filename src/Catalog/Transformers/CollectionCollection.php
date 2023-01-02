<?php

namespace Modules\Catalog\Transformers;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CollectionCollection extends ResourceCollection
{
    public function toArray($request): array
    {
        return [
            'data' => CollectionResource::collection($this->collection)
        ];
    }
}

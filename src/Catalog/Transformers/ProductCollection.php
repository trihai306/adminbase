<?php

namespace Modules\Catalog\Transformers;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductCollection extends ResourceCollection
{
    public function toArray($request): array
    {
        return [
            'data' => ProductResource::collection($this->collection)
        ];
    }
}

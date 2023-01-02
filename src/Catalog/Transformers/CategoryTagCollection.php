<?php

namespace Modules\Catalog\Transformers;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CategoryTagCollection extends ResourceCollection
{
    public function toArray($request): array
    {
        return [
            'data' => CategoryTagResource::collection($this->collection)
        ];
    }
}

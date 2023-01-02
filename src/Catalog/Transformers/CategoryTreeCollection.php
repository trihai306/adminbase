<?php

namespace Modules\Catalog\Transformers;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CategoryTreeCollection extends ResourceCollection
{
    public function toArray($request): array
    {
        return [
            'data' => CategoryTreeResource::collection($this->collection)
        ];
    }
}

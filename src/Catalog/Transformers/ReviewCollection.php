<?php

namespace Modules\Catalog\Transformers;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ReviewCollection extends ResourceCollection
{
    public function toArray($request): array
    {
        return [
            'data' => ReviewResource::collection($this->collection)
        ];
    }
}

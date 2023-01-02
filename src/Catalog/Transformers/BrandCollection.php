<?php

namespace Modules\Catalog\Transformers;

use Illuminate\Http\Resources\Json\ResourceCollection;

class BrandCollection extends ResourceCollection
{
    public function toArray($request): array
    {
        return [
            'data' => BrandResource::collection($this->collection)
        ];
    }
}

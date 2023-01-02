<?php

namespace Modules\Catalog\Transformers;

use Illuminate\Http\Resources\Json\ResourceCollection;

class VariantCollection extends ResourceCollection
{
    public function toArray($request): array
    {
        return [
            'data' => VariantResource::collection($this->collection)
        ];
    }
}

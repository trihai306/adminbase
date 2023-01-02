<?php

namespace Modules\Catalog\Transformers;

use Illuminate\Http\Resources\Json\ResourceCollection;

class AttributeCollection extends ResourceCollection
{
    public function toArray($request): array
    {
        return [
            'data' => AttributeResource::collection($this->collection)
        ];
    }
}

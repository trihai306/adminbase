<?php

namespace Modules\Cart\Transformers;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CartCollection extends ResourceCollection
{
    public function toArray($request): array
    {
        return [
            'data' => CartResource::collection($this->collection)
        ];
    }
}

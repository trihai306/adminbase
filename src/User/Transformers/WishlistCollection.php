<?php

namespace Modules\User\Transformers;

use Illuminate\Http\Resources\Json\ResourceCollection;

class WishlistCollection extends ResourceCollection
{
    public function toArray($request): array
    {
        return [
            'data' => WishlistResource::collection($this->collection)
        ];
    }
}

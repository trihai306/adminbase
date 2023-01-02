<?php

namespace Modules\Catalog\Transformers;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PromotionCollection extends ResourceCollection
{
    public function toArray($request): array
    {
        return [
            'data' => PromotionResource::collection($this->collection)
        ];
    }
}

<?php

namespace Modules\Payment\Transformers;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CardCollection extends ResourceCollection
{
    public function toArray($request): array
    {
        return [
            'data' => CardResource::collection($this->collection)
        ];
    }
}

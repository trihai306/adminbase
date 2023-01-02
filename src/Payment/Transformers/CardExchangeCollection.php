<?php

namespace Modules\Payment\Transformers;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CardExchangeCollection extends ResourceCollection
{
    public function toArray($request): array
    {
        return [
            'data' => CardExchangeResource::collection($this->collection)
        ];
    }
}

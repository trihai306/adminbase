<?php

namespace Modules\User\Transformers;

use Illuminate\Http\Resources\Json\ResourceCollection;

class TransactionCollection extends ResourceCollection
{
    public function toArray($request): array
    {
        return [
            'data' => TransactionResource::collection($this->collection)
        ];
    }
}

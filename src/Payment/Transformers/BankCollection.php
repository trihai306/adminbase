<?php

namespace Modules\Payment\Transformers;

use Illuminate\Http\Resources\Json\ResourceCollection;

class BankCollection extends ResourceCollection
{
    public function toArray($request): array
    {
        return [
            'data' => BankResource::collection($this->collection)
        ];
    }
}

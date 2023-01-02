<?php

namespace Modules\Payment\Transformers;

use Illuminate\Http\Resources\Json\ResourceCollection;

class BankTransferCollection extends ResourceCollection
{
    public function toArray($request): array
    {
        return [
            'data' => BankTransferResource::collection($this->collection)
        ];
    }
}

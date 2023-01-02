<?php

namespace Modules\Payment\Transformers;

use Illuminate\Http\Resources\Json\ResourceCollection;

class EwalletTransferCollection extends ResourceCollection
{
    public function toArray($request): array
    {
        return [
            'data' => EwalletTransferResource::collection($this->collection)
        ];
    }
}

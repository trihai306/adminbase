<?php

namespace Modules\Payment\Transformers;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PaymentCollection extends ResourceCollection
{
    public function toArray($request): array
    {
        return [
            'data' => PaymentResource::collection($this->collection)
        ];
    }
}

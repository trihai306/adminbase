<?php

namespace Modules\Payment\Transformers;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PaymentMethodCollection extends ResourceCollection
{
    public function toArray($request): array
    {
        return [
            'data' => PaymentMethodResource::collection($this->collection)
        ];
    }
}

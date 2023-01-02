<?php

namespace Modules\Catalog\Transformers;

use Illuminate\Http\Resources\Json\ResourceCollection;

class VoucherCollection extends ResourceCollection
{
    public function toArray($request): array
    {
        return [
            'data' => VoucherResource::collection($this->collection)
        ];
    }
}

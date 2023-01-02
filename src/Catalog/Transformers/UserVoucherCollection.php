<?php

namespace Modules\Catalog\Transformers;

use Illuminate\Http\Resources\Json\ResourceCollection;

class UserVoucherCollection extends ResourceCollection
{
    public function toArray($request): array
    {
        return [
            'data' => UserVoucherResource::collection($this->collection)
        ];
    }
}

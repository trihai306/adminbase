<?php

namespace Modules\User\Transformers;

use Illuminate\Http\Resources\Json\ResourceCollection;

class RoleCollection extends ResourceCollection
{
    public function toArray($request): array
    {
        return [
            'data' => RoleResource::collection($this->collection)
        ];
    }
}

<?php

namespace Modules\User\Transformers;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PermissionCollection extends ResourceCollection
{
    public function toArray($request): array
    {
        return [
            'data' => PermissionResource::collection($this->collection)
        ];
    }
}

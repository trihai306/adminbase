<?php

namespace Modules\User\Transformers;

use Illuminate\Http\Resources\Json\ResourceCollection;

class LoginHistoryCollection extends ResourceCollection
{
    public function toArray($request): array
    {
        return [
            'data' => LoginHistoryResource::collection($this->collection)
        ];
    }
}

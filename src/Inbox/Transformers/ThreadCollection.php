<?php

namespace Modules\Inbox\Transformers;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ThreadCollection extends ResourceCollection
{
    public function toArray($request): array
    {
        return [
            'data' => ThreadResource::collection($this->collection)
        ];
    }
}

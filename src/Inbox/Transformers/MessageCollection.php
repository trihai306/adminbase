<?php

namespace Modules\Inbox\Transformers;

use Illuminate\Http\Resources\Json\ResourceCollection;

class MessageCollection extends ResourceCollection
{
    public function toArray($request): array
    {
        return [
            'data' => MessageResource::collection($this->collection)
        ];
    }
}

<?php

namespace Modules\Inbox\Transformers;

use Illuminate\Http\Resources\Json\ResourceCollection;

class NoteCollection extends ResourceCollection
{
    public function toArray($request): array
    {
        return [
            'data' => NoteResource::collection($this->collection)
        ];
    }
}

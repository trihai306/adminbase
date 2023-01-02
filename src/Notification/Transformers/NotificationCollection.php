<?php

namespace Modules\Notification\Transformers;

use Illuminate\Http\Resources\Json\ResourceCollection;

class NotificationCollection extends ResourceCollection
{
    public function toArray($request): array
    {
        return [
            'data' => NotificationResource::collection($this->collection)
        ];
    }
}

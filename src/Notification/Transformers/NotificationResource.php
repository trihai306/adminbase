<?php

namespace Modules\Notification\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'message' => $this->message,
            'data' => $this->data,
            'read_at' => $this->read_at,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at
        ];
    }
}

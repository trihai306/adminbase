<?php

namespace Modules\Inbox\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Media\Casts\File;

class MessageResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'thread_id' => $this->thread_id,
            'sender_id' => $this->sender_id,
            'sender' => $this->whenLoaded('sender', function () {
                return new SenderResource($this->sender);
            }),
            'body' => is_array($this->body) ? array_merge($this->body, [
                'image' => new File($this->body['image'])
            ]) : $this->body,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at
        ];
    }
}

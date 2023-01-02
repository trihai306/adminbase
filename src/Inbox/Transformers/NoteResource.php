<?php

namespace Modules\Inbox\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\User\Transformers\UserResource;

class NoteResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'thread_id' => $this->thread_id,
            'thread' => $this->whenLoaded('thread', function () {
                return new ThreadResource($this->thread);
            }),
            'user_id' => $this->user_id,
            'user' => $this->whenLoaded('user', function () {
                return new UserResource($this->user);
            }),
            'content' => $this->content,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at
        ];
    }
}

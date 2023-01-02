<?php

namespace Modules\Inbox\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class SenderResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'avatar' => $this->avatar_url,
            'username' => $this->username,
            'full_name' => $this->full_name,
            'last_seen_at' => $this->whenPivotLoaded('thread_participant', function () {
                return $this->pivot->last_seen_at;
            }),
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at
        ];
    }
}

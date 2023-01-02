<?php

namespace Modules\Catalog\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class ReviewerResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'avatar' => $this->avatar,
            'username' => $this->username,
            'full_name' => $this->full_name,
            'email' => $this->email,
            'rank' => $this->rank,
            'is_admin' => $this->is_admin,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at
        ];
    }
}

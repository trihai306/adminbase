<?php

namespace Modules\User\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Catalog\Transformers\ProductResource;

class LoginHistoryResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'ip' => $this->ip,
            'agent' => $this->agent,
            'country' => $this->country,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at
        ];
    }
}

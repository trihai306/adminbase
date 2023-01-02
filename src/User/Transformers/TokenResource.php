<?php

namespace Modules\User\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class TokenResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'type' => 'Bearer',
            'token' => $this->plainTextToken
        ];
    }
}

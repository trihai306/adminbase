<?php

namespace Modules\User\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'user' => $this->whenLoaded('user', function () {
                return new UserResource($this->user);
            }),
            'amount' => $this->amount,
            'balance' => $this->balance,
            'content' => $this->content,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at
        ];
    }
}

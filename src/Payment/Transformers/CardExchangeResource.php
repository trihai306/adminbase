<?php

namespace Modules\Payment\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class CardExchangeResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'card_id' => $this->card_id,
            'card' => $this->whenLoaded('card', function () {
                return new CardResource($this->card);
            }),
            'type' => $this->type,
            'serial' => $this->serial,
            'code' => $this->code,
            'value' => $this->value,
            'real_value' => $this->real_value,
            'discount_rate' => $this->discount_rate,
            'receive_amount' => $this->receive_amount,
            'feedback' => $this->feedback,
            'status' => $this->status,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at
        ];
    }
}

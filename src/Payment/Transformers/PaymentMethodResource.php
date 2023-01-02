<?php

namespace Modules\Payment\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class PaymentMethodResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'code' => $this->code,
            'name' => $this->name,
            'image' => $this->image,
            'description' => $this->description,
            'config' => $this->config,
            'banks' => $this->whenLoaded('banks', function () {
                return BankResource::collection($this->banks);
            }),
            'cards' => $this->whenLoaded('cards', function () {
                return CardResource::collection($this->cards);
            }),
            'ewallets' => $this->whenLoaded('ewallets', function () {
                return EwalletResource::collection($this->ewallets);
            }),
            'checkout_enabled' => $this->checkout_enabled,
            'recharge_enabled' => $this->recharge_enabled,
            'status' => $this->status,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at
        ];
    }
}

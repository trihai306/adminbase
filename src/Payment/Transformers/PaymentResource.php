<?php

namespace Modules\Payment\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'method_id' => $this->method_id,
            'method_type' => $this->method_type,
            'method' => $this->whenLoaded('method', function () {
                return new PaymentMethodResource($this->method);
            }),
            'amount' => $this->amount,
            'discount_rate' => $this->discount_rate,
            'receive_amount' => $this->receive_amount,
            'payer_id' => $this->payer_id,
            'payer' => $this->whenLoaded('payer', function () {
                return new PayerResource($this->payer);
            }),
            'expired_at' => $this->expired_at,
            'feed_back' => $this->feed_back,
            'card_exchanges' => $this->whenLoaded('card_exchanges', function () {
                return CardExchangeResource::collection($this->card_exchanges);
            }),
            'bank_transfer' => $this->whenLoaded('bank_transfer', function () {
                return new BankTransferResource($this->bank_transfer);
            }),
            'ewallet_transfer' => $this->whenLoaded('ewallet_transfer', function () {
                return new EwalletTransferResource($this->ewallet_transfer);
            }),
            'expire_at' => $this->expire_at,
            'status' => $this->status,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at
        ];
    }
}

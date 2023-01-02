<?php

namespace Modules\Payment\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class EwalletTransferResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'payment_id' => $this->payment_id,
            'payment' => $this->whenLoaded('payment', function () {
                return new PaymentResource($this->payment);
            }),
            'ewallet_id' => $this->ewallet_id,
            'ewallet' => $this->whenLoaded('ewallet', function () {
                return new EwalletResource($this->ewallet);
            }),
            'ref' => $this->ref,
            'content' => $this->content,
            'amount' => $this->amount,
            'receive_amount' => $this->receive_amount,
            'transacted_at' => $this->transacted_at,
            'bill' => $this->bill,
            'feed_back' => $this->feed_back,
            'status' => $this->status,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at
        ];
    }
}

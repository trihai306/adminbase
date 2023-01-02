<?php

namespace Modules\Payment\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class BankTransferResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'payment_id' => $this->payment_id,
            'payment' => $this->whenLoaded('payment', function () {
                return new PaymentResource($this->payment);
            }),
            'bank_id' => $this->bank_id,
            'bank' => $this->whenLoaded('bank', function () {
                return new BankResource($this->bank);
            }),
            'ref' => $this->ref,
            'content' => $this->content,
            'amount' => $this->amount,
            'discount_rate' => $this->discount_rate,
            'receive_amount' => $this->receive_amount,
            'transacted_at' => $this->transacted_at,
            'bill' => $this->bill,
            'feedback' => $this->feedback,
            'status' => $this->status,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at
        ];
    }
}

<?php

namespace Modules\Order\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Payment\Transformers\PaymentMethodResource;
use Modules\Payment\Transformers\PaymentResource;
use Modules\User\Transformers\TransactionResource;
use Modules\User\Transformers\UserResource;

class OrderResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'buyer_id' => $this->buyer_id,
            'buyer' => $this->whenLoaded('buyer', function () {
                return new UserResource($this->buyer);
            }),
            'payment_method_id' => $this->payment_method_id,
            'payment_method' => $this->whenLoaded('payment_method', function () {
                return new PaymentMethodResource($this->payment_method);
            }),
            'payment' => $this->whenLoaded('payment', function () {
                return new PaymentResource($this->payment);
            }),
            'transaction_id' => $this->transaction_id,
            'transaction' => $this->whenLoaded('transaction', function () {
                return new TransactionResource($this->transaction);
            }),
            'items' => $this->whenLoaded('items', function () {
                return OrderItemResource::collection($this->items);
            }),
            'items_count' => $this->when($this->items_count, $this->items_count),
            'total' => $this->total,
            'status' => $this->status,
            'updated_at' => $this->upated_at,
            'created_at' => $this->created_at
        ];
    }
}

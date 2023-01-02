<?php

namespace Modules\Order\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Order\Entities\OrderItem;
use Modules\User\Transformers\TransactionResource;
use Modules\User\Transformers\UserResource;

class OrderStatusResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'code' => $this->value,
            'name' => $this->description,
            'order_items_count' => OrderItem::where('status', $this->value)
                ->count()
        ];
    }
}

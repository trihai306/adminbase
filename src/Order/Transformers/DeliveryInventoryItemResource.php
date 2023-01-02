<?php

namespace Modules\Order\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Order\Entities\OrderItem;
use Modules\User\Transformers\TransactionResource;
use Modules\User\Transformers\UserResource;

class DeliveryInventoryItemResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'order_item_id' => $this->order_item_id,
            'inventory_item_id' => $this->inventory_item_id,
            'item' => $this->item,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at
        ];
    }
}

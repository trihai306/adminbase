<?php

namespace Modules\Order\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Catalog\Transformers\ReviewResource;
use Modules\Catalog\Transformers\VariantResource;

class OrderItemResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'code' => $this->id,
            'order_id' => $this->order_id,
            'order' => $this->whenLoaded('order', function () {
                return new OrderResource($this->order);
            }),
            'variant_id' => $this->variant_id,
            'variant' => $this->whenLoaded('variant', function () {
                return new VariantResource($this->variant);
            }),
            'delivery_inventory_items' => $this->whenLoaded('delivery_inventory_items', function () {
                return DeliveryInventoryItemResource::collection($this->delivery_inventory_items);
            }),
            'delivery_inventory_items_count' => $this->when($this->delivery_inventory_items_count, $this->delivery_inventory_items_count),
            'rating' => $this->whenLoaded('rating', function () {
                return new ReviewResource($this->rating);
            }),
            'name' => $this->name,
            'image' => $this->image,
            'quantity' => $this->quantity,
            'price' => $this->price,
            'discount_price' => $this->discount_price,
            'sale_price' => $this->sale_price,
            'total' => $this->total,
            'order_type' => $this->order_type,
            'status' => $this->status,
            'updated_at' => $this->upated_at,
            'created_at' => $this->created_at
        ];
    }
}

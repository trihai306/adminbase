<?php

namespace Modules\Inventory\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Catalog\Transformers\VariantResource;

class InventoryResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'name' => $this->name,
            'image' => $this->image,
            'items' => $this->whenLoaded('items', function () {
                return InventoryItemResource::collection($this->items);
            }),
            'available_items' => $this->whenLoaded('available_items', function () {
                return InventoryItemResource::collection($this->available_items);
            }),
            'sold_items' => $this->whenLoaded('sold_items', function () {
                return InventoryItemResource::collection($this->sold_items);
            }),
            'items_count' => $this->when(is_numeric($this->items_count), $this->items_count),
            'available_items_count' => $this->when(is_numeric($this->available_items_count), $this->available_items_count),
            'sold_items_count' => $this->when(is_numeric($this->sold_items_count), $this->sold_items_count),
            'status' => $this->inventory_status,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at
        ];
    }
}

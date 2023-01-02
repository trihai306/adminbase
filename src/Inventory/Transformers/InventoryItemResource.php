<?php

namespace Modules\Inventory\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;
use Modules\User\Transformers\UserResource;

class InventoryItemResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'inventory_id' => $this->inventory_id,
            'inventory' => $this->whenLoaded('inventory', function () {
                return new InventoryResource($this->inventory);
            }),
            'item' => $this->item,
            'importer_id' => $this->importer_id,
            'importer' => $this->whenLoaded('importer', function () {
                return new UserResource($this->importer);
            }),
            'status' => $this->status,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at
        ];
    }
}

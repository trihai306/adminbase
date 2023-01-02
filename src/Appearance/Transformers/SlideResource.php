<?php

namespace Modules\Appearance\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class SlideResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'name' => $this->name,
            'items' => $this->whenLoaded('items', function () {
                return SlideItemResource::collection($this->items);
            }),
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at
        ];
    }
}

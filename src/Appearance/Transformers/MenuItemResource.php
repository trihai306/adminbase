<?php

namespace Modules\Appearance\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class MenuItemResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'icon' => $this->icon,
            'name' => $this->name,
            'url' => $this->url,
            'children' => $this->whenLoaded('children', function () {
                return self::collection($this->children);
            }),
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
        ];
    }
}

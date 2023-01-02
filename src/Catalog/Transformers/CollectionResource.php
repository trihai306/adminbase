<?php

namespace Modules\Catalog\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class CollectionResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'name' => $this->name,
            'slug' => optional($this->slug)->slug,
            'image' => $this->image,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at
        ];
    }
}

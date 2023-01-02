<?php

namespace Modules\Catalog\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryTagResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'categories_count' => $this->categories_count,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at
        ];
    }
}

<?php

namespace Modules\Catalog\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class OptionResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'name' => $this->name,
            'image' => $this->image,
            'values' => $this->whenLoaded('values', function () {
                return OptionValueResource::collection($this->values);
            }),
            'description' => $this->description,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at
        ];
    }
}

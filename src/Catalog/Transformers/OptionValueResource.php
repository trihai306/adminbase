<?php

namespace Modules\Catalog\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class OptionValueResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'option_id' => $this->option_id,
            'code' => $this->code,
            'name' => $this->name,
            'image' => $this->image,
            'description' => $this->description,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at
        ];
    }
}

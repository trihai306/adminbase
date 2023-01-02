<?php

namespace Modules\Appearance\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class SlideItemResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'image' => $this->image,
            'url' => $this->url,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at
        ];
    }
}

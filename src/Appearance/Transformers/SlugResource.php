<?php

namespace Modules\Appearance\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class SlugResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'slugable_id' => $this->slugable_id,
            'slugable_type' => $this->slugable_type,
            'slugable' => $this->whenLoaded('slugable', function () {
                return $this->slugable;
            }),
            'keywords' => $this->keywords,
            'description' => $this->description,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
        ];
    }
}

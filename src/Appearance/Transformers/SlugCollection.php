<?php

namespace Modules\Appearance\Transformers;

use Illuminate\Http\Resources\Json\ResourceCollection;

class SlugCollection extends ResourceCollection
{
    public function toArray($request): array
    {
        return [
            'data' => SlugResource::collection($this->collection)
        ];
    }
}

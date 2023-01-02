<?php

namespace Modules\Appearance\Transformers;

use Illuminate\Http\Resources\Json\ResourceCollection;

class SlideCollection extends ResourceCollection
{
    public function toArray($request): array
    {
        return [
            'data' => SlideResource::collection($this->collection)
        ];
    }
}

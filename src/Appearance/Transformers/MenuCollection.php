<?php

namespace Modules\Appearance\Transformers;

use Illuminate\Http\Resources\Json\ResourceCollection;

class MenuCollection extends ResourceCollection
{
    public function toArray($request): array
    {
        return [
            'data' => MenuResource::collection($this->collection)
        ];
    }
}

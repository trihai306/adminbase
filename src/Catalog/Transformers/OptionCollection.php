<?php

namespace Modules\Catalog\Transformers;

use Illuminate\Http\Resources\Json\ResourceCollection;

class OptionCollection extends ResourceCollection
{
    public function toArray($request): array
    {
        return [
            'data' => OptionResource::collection($this->collection)
        ];
    }
}

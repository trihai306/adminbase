<?php

namespace Modules\Catalog\Transformers;

use Illuminate\Http\Resources\Json\ResourceCollection;

class HistoryPointCollection extends ResourceCollection
{
    public function toArray($request): array
    {
        return [
            'data' => HistoryPointResource::collection($this->collection)
        ];
    }
}

<?php

namespace Modules\User\Transformers;

use Illuminate\Http\Resources\Json\ResourceCollection;

class IdentifyProviderCollection extends ResourceCollection
{
    public function toArray($request): array
    {
        return [
            'data' => IdentifyProviderResource::collection($this->collection)
        ];
    }
}

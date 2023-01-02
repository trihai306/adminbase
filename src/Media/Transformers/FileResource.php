<?php

namespace Modules\Media\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class FileResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'path' => $this->path,
            'url' => $this->url
        ];
    }
}

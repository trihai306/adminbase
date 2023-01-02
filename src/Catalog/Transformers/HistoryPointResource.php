<?php

namespace Modules\Catalog\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class HistoryPointResource extends JsonResource
{
    public function toArray($request): array
    {

        return [
            'id' => $this->id,
            'users'=>$this->whenLoaded('users', function () {
                return $this->users;
            }),
            'point'=>$this->point,
            'note'=>$this->note,
            'type'=>$this->type,
            'status' => $this->status,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at
        ];
    }
}

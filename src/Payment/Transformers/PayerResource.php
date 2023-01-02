<?php

namespace Modules\Payment\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class PayerResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'avatar' => $this->avatar,
            'full_name' => $this->full_name,
            'email' => $this->email,
            'phone' => $this->phone
        ];
    }
}

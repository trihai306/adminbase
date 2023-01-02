<?php

namespace Modules\Payment\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class BankResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'payment_method_id' => $this->payment_method_id,
            'name' => $this->name,
            'image' => $this->image,
            'account_name' => $this->account_name,
            'account_number' => $this->account_number,
            'branch' => $this->branch,
            'discount_rate' => $this->discount_rate,
            'status' => $this->status,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at
        ];
    }
}

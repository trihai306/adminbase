<?php

namespace Modules\Catalog\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class UserVoucherResource extends JsonResource
{
    public function toArray($request): array
    {

        return [
            'voucher' => $this->whenLoaded('voucher', function () {
                return new VoucherResource($this->voucher);
            }),
            'id'=>$this->id,
            'expire_at'=>$this->expire_at,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at
        ];
    }
}

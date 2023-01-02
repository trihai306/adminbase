<?php

namespace Modules\Catalog\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class VoucherResource extends JsonResource
{
    public function toArray($request): array
    {

        return [
            'id' => $this->id,
            'code' => $this->code,
            'name' => $this->name,
            'title' => $this->title,
            'max_money' => $this->max_money,
            'discount' => $this->discount,
            'quality' => $this->quality,
            'point' => $this->point,
            'description' => $this->description,
            'status' => $this->status,
            'expire_day'=> $this->expire_day,
            'start_at' => $this->start_at,
            'end_at' => $this->end_at,
            'variant_ids' => $this->whenLoaded('variant_ids', function () {
                return $this->variant_ids->pluck('variant_id');
            }),
            'variants'=>$this->whenLoaded('variants',function (){
                return VariantResource::collection($this->variants);
            }),
            'product_ids' => $this->whenLoaded('product_ids', function () {
                return $this->product_ids->pluck('product_id');
            }),
            'products'=>$this->whenLoaded('products',function (){
                return VariantResource::collection($this->products);
            }),
            'user_ids' => $this->whenLoaded('user_ids', function () {
                return $this->user_ids->pluck('user_id');
            }),
            'type' => $this->type,
            'options' => $this->options,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at
        ];
    }
}

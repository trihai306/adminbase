<?php

namespace Modules\Catalog\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class VariantResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'product_id' => $this->product_id,
            'code' => $this->code,
            'name' => $this->name,
            'image' => $this->image,
            'price' => $this->price,
            'discount_price' => $this->discount_price,
            'discount_percent' => $this->discount_percent,
            'sale_price' => $this->sale_price,
            'order_type' => $this->order_type,
            'stock_status' => $this->stock_status,
            'option_values' => $this->whenLoaded('option_values', function () {
                return OptionValueResource::collection($this->option_values);
            }),
            'option_value_ids' => $this->whenLoaded('option_value_ids', function () {
                return $this->option_value_ids->pluck('id');
            }),
            'is_default' => $this->is_default,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at
        ];
    }
}

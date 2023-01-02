<?php

namespace Modules\Catalog\Requests\Admin;

use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Validation\Rules\Exists;
use Illuminate\Validation\Rules\Unique;
use Modules\Catalog\Entities\Attribute;
use Modules\Catalog\Entities\OptionValue;
use Modules\Catalog\Entities\Product;
use Modules\Catalog\Entities\Variant;
use Modules\Catalog\Enums\OrderType;
use Modules\Catalog\Enums\StockStatus;
use Modules\Core\Requests\FormRequest;
use Modules\Media\Enums\MediaType;
use Modules\Media\Rules\MediaFile;

class StoreVariantRequest extends FormRequest
{
    public function rules(): array
    {
         return [
             'product_id' => [
                 'required',
                 new Exists(Product::class)
             ],
             'code' => [
                 'nullable',
                 new Unique(Variant::class, 'code'),
             ],
             'name' => 'required',
             'variants.*.image' => [
                 'nullable',
                 new MediaFile(MediaType::IMAGE)
             ],
             'price' => [
                 'required',
                 'integer',
                 'min:0'
             ],
             'order_type' => [
                 'required',
                 new EnumValue(OrderType::class)
             ],
             'stock_status' => new EnumValue(StockStatus::class),
             'is_default' => [
                 'required',
                 'boolean'
             ],
             'option_value_ids' => 'array',
             'option_value_ids.*' => new Exists(OptionValue::class, 'id'),
             'attribute_values' => 'array',
             'attribute_values.*' => 'array',
             'attribute_values.*.attribute_id' => new Exists(Attribute::class, 'id'),
             'attribute_values.*.value' => 'nullable'
         ];
    }
}

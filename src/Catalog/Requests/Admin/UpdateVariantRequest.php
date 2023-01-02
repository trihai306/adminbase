<?php

namespace Modules\Catalog\Requests\Admin;

use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Validation\Rules\Exists;
use Illuminate\Validation\Rules\Unique;
use Modules\Catalog\Entities\Attribute;
use Modules\Catalog\Entities\OptionValue;
use Modules\Catalog\Entities\Variant;
use Modules\Catalog\Enums\OrderType;
use Modules\Catalog\Enums\StockStatus;
use Modules\Core\Requests\FormRequest;
use Modules\Media\Enums\MediaType;
use Modules\Media\Rules\MediaFile;

class UpdateVariantRequest extends FormRequest
{
    public function rules(): array
    {
         return [
             'code' => [
                 'nullable',
                 (new Unique(Variant::class, 'code'))
                    ->ignore($this->route('variant')),
             ],
             'name' => 'filled',
             'variants.*.image' => [
                 'nullable',
                 new MediaFile(MediaType::IMAGE)
             ],
             'price' => [
                 'filled',
                 'integer',
                 'min:0'
             ],
             'order_type' => [
                 'filled',
                 new EnumValue(OrderType::class)
             ],
             'stock_status' => new EnumValue(StockStatus::class),
             'is_default' => [
                 'filled',
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

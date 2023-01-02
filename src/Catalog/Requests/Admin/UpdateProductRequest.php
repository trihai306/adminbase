<?php

namespace Modules\Catalog\Requests\Admin;

use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Validation\Rules\Exists;
use Illuminate\Validation\Rules\Unique;
use Modules\Appearance\Entities\Slug;
use Modules\Catalog\Entities\Attribute;
use Modules\Catalog\Entities\Category;
use Modules\Catalog\Entities\Collection;
use Modules\Catalog\Entities\Option;
use Modules\Catalog\Entities\OptionValue;
use Modules\Catalog\Entities\Product;
use Modules\Catalog\Entities\Variant;
use Modules\Catalog\Enums\OrderType;
use Modules\Catalog\Enums\ProductStatus;
use Modules\Catalog\Enums\ProductType;
use Modules\Catalog\Enums\StockStatus;
use Modules\Catalog\Enums\VariantMatchingMethod;
use Modules\Core\Requests\FormRequest;
use Modules\Media\Enums\MediaType;
use Modules\Media\Rules\MediaFile;

class UpdateProductRequest extends FormRequest
{
    public function rules(): array
    {
        $productId = $this->route('product');

         return [
             'code' => [
                 'nullable',
                 (new Unique(Product::class))
                    ->ignore($productId)
             ],
             'name' => 'filled',
             'slug' => [
                 'filled',
                 (new Unique(Slug::class))
                     ->where('slugable_type', Product::class)
                     ->ignore($productId, 'slugable_id')
             ],
             'image' => [
                 'nullable',
                 new MediaFile(MediaType::IMAGE)
             ],
             'images' => 'array',
             'images.*' => new MediaFile(MediaType::IMAGE),
             'variant_matching_method' => [
                 'nullable',
                 new EnumValue(VariantMatchingMethod::class)
             ],
             'initial_sold_count' => [
                 'integer',
                 'min:0'
             ],
             'important_message' => 'nullable',
             'content' => 'nullable',
             'category_id' => new Exists(Category::class, 'id'),
             'category_ids' => [
                 'array',
                 new Exists(Category::class, 'id')
             ],
             'collection_ids' => [
                 'array',
                 new Exists(Collection::class, 'id')
             ],
             'option_ids' => [
                 'array',
                 new Exists(Option::class, 'id')
             ],
             'attribute_ids' => [
                 'array',
                 new Exists(Attribute::class, 'id')
             ],
             'related_product_ids' => [
                 'array',
                 (new Exists(Product::class, 'id'))
                    ->whereNot('id', $productId)
             ],
             'variants' => 'array',
             'variants.*' => 'array',
             'variants.*.id' => [
                 'nullable',
                 new Exists(Variant::class)
             ],
             'variants.*.code' => [
                 'nullable',
                 new Unique(Variant::class, 'code'),
             ],
             'variants.*.name' => 'filled',
             'variants.*.image' => [
                 'nullable',
                 new MediaFile(MediaType::IMAGE)
             ],
             'variants.*.price' => [
                 'filled',
                 'integer',
                 'min:0'
             ],
             'variants.*.order_type' => [
                 'filled',
                 new EnumValue(OrderType::class)
             ],
             'variants.*.stock_status' => new EnumValue(StockStatus::class),
             'variants.*.is_default' => [
                 'filled',
                 'boolean'
             ],
             'variants.*.option_value_ids' => [
                 'array',
                 new Exists(OptionValue::class, 'id')
             ],
             'variants.*.attribute_values' => 'array',
             'variants.*.attribute_values.*' => 'array',
             'variants.*.attribute_values.*.attribute_id' => new Exists(Attribute::class, 'id'),
             'variants.*.attribute_values.*.value' => 'nullable',
             'status' => [
                 'filled',
                 new EnumValue(ProductStatus::class)
             ]
         ];
    }
}

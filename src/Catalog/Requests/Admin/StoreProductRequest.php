<?php

namespace Modules\Catalog\Requests\Admin;

use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Validation\Rules\Exists;
use Illuminate\Validation\Rules\Unique;
use Modules\Appearance\Entities\Slug;
use Modules\Catalog\Entities\Attribute;
use Modules\Catalog\Entities\Brand;
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

class StoreProductRequest extends FormRequest
{
    public function rules(): array
    {
         return [
             'code' => [
                 'nullable',
                 new Unique(Product::class)
             ],
             'name' => 'required',
             'slug' => [
                 'required',
                 new Unique(Slug::class)
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
             'brand_id' => new Exists(Brand::class, 'id'),
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
                 new Exists(Product::class, 'id')
             ],
             'variants' => [
                 'required',
                 'array'
             ],
             'variants.*' => 'array',
             'variants.*.code' => [
                 'nullable',
                 new Unique(Variant::class, 'code'),
             ],
             'variants.*.name' => 'required',
             'variants.*.image' => [
                 'nullable',
                 new MediaFile(MediaType::IMAGE)
             ],
             'variants.*.price' => [
                 'required',
                 'integer',
                 'min:0'
             ],
             'variants.*.order_type' => [
                 'required',
                 new EnumValue(OrderType::class)
             ],
             'variants.*.stock_status' => new EnumValue(StockStatus::class),
             'variants.*.is_default' => [
                 'required',
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
                 'required',
                 new EnumValue(ProductStatus::class)
             ]
         ];
    }
}

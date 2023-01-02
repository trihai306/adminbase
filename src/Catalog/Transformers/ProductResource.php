<?php

namespace Modules\Catalog\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'name' => $this->name,
            'slug' => optional($this->slug)->slug,
            'image' => $this->image,
            'images' => $this->images,
            'variant_matching_method' => $this->variant_matching_method,
            'sold_count' => $this->sold_count,
            'initial_sold_count' => $this->initial_sold_count,
            'important_message' => $this->important_message,
            'category_id' => $this->category_id,
            'category' => $this->whenLoaded('category', function () {
                return new CategoryResource($this->category);
            }),
            'attributes' => $this->whenLoaded('attributes', function () {
                return AttributeResource::collection($this->attributes);
            }),
            'attribute_ids' => $this->whenLoaded('attribute_ids', function () {
                return $this->attribute_ids->pluck;
            }),
            'options' => $this->whenLoaded('options', function () {
                return OptionResource::collection($this->options);
            }),
            'option_ids' => $this->whenLoaded('option_ids', function () {
                return $this->option_ids->pluck('id');
            }),
            'categories' => $this->whenLoaded('categories', function () {
                return CategoryResource::collection($this->categories);
            }),
            'category_ids' => $this->whenLoaded('category_ids', function () {
                return $this->category_ids->pluck('id');
            }),
            'collections' => $this->whenLoaded('collections', function () {
                return CollectionResource::collection($this->collections);
            }),
            'collection_ids' => $this->whenLoaded('collection_ids', function () {
                return $this->collection_ids->pluck('id');
            }),
            'related_products' => $this->whenLoaded('related_products', function () {
                return ProductResource::collection($this->related_products);
            }),
            'related_product_ids' => $this->whenLoaded('related_product_ids', function () {
                return $this->related_product_ids->pluck('id');
            }),
            'default_variant' => $this->whenLoaded('default_variant', function () {
                return new VariantResource($this->default_variant);
            }),
            'variants' => $this->whenLoaded('variants', function () {
                return VariantResource::collection($this->variants);
            }),
            'reviews' => $this->whenLoaded('reviews', function () {
                return ReviewResource::collection($this->reviews);
            }),
            'ratings' => $this->whenLoaded('ratings', function () {
                return ReviewResource::collection($this->reviews);
            }),
            'ratings_count' => $this->when('ratings_count', $this->ratings_count),
            'ratings_avg' => $this->when('ratings_avg_rating', $this->ratings_avg_rating),
            'status' => $this->status,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at
        ];
    }
}

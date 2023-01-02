<?php

namespace Modules\Catalog\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'name' => $this->name,
            'slug' => optional($this->slug)->slug,
            'icon' => $this->icon,
            'image' => $this->image,
            'parent_id' => $this->parent_id,
            'parent' => $this->whenLoaded('parent', function () {
                return new self($this->parent);
            }),
            'children' => $this->whenLoaded('children', function () {
                return self::collection($this->children);
            }),
            'ancestors' => $this->whenLoaded('ancestors', function () {
                return self::collection($this->ancestors);
            }),
            'descendants' => $this->whenLoaded('descendants', function () {
                return self::collection($this->descendants);
            }),
            'children_tags' => $this->whenLoaded('children_tags', function () {
                return CategoryTagResource::collection($this->children_tags);
            }),
            'children_tag_ids' => $this->whenLoaded('children_tag_ids', function () {
                return $this->children_tag_ids->pluck('id');
            }),
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at
        ];
    }
}

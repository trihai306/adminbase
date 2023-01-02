<?php

namespace Modules\Catalog\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryTreeResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'name' => $this->name,
            'image' => $this->image,
            'slug' => optional($this->slug)->slug,
            'parent_id' => $this->parent_id,
            'children' => $this->whenLoaded('children', function () {
                return self::collection($this->children);
            }),
            'tags' => $this->whenLoaded('tags', function () {
                return CategoryTagResource::collection($this->tags);
            }),
            'tag_ids' => $this->whenLoaded('tag_ids', function () {
                return $this->tag_ids->pluck('id');
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

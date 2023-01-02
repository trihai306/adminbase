<?php

namespace Modules\Catalog\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'reviewer_id' => $this->reviewer_id,
            'reviewer' => $this->whenLoaded('reviewer', function () {
                return new ReviewerResource($this->reviewer);
            }),
            'product_id' => $this->product_id,
            'product' => $this->whenLoaded('product', function () {
                return new ProductResource($this->product);
            }),
            'parent_id' => $this->parent_id,
            'rating' => $this->rating,
            'comment' => $this->comment,
            'replies' => $this->whenLoaded('replies', function () {
                return self::collection($this->replies);
            }),
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at
        ];
    }
}

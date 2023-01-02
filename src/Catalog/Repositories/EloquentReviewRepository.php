<?php

namespace Modules\Catalog\Repositories;

use Modules\Catalog\Entities\Review;
use Modules\Core\Repositories\EloquentRepository;

class EloquentReviewRepository extends EloquentRepository implements ReviewRepository
{
    protected $allowedSearch = true;

    protected $allowedFilters = [
        'id',
        'reviewer_id',
        'product_id',
        'parent_id',
        'rating'
    ];

    protected $allowedSorts = [
        'id',
        'reviewer_id',
        'product_id',
        'parent_id',
        'rating',
        'updated_at',
        'created_at'
    ];

    protected $allowedIncludes = [
        'reviewer',
        'product',
        'replies',
        'replies.reviewer'
    ];

    public function __construct(Review $model)
    {
        parent::__construct($model);
    }

    public function query(array $conditions)
    {
        $query = $this->model->newQuery();

        if (isset($conditions['product_id'])) {
            $query = $query->where('product_id', $conditions['product_id']);
        }

        if (array_key_exists('parent_id', $conditions)) {
            if ($conditions['parent_id'] === null) {
                $query = $query->whereNull('parent_id');
            } else {
                $query = $query->where('parent_id', $conditions['parent_id']);
            }
        }

        return $this->executeQuery($conditions, $query);
    }

    public function getRatingsCount($productId)
    {
        return $this->model->newQuery()
            ->where('product_id', $productId)
            ->rating()
            ->count();
    }

    public function getRatingsAvg($productId)
    {
        return $this->model->newQuery()
            ->where('product_id', $productId)
            ->rating()
            ->avg('rating');
    }


}

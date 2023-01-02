<?php

namespace Modules\Catalog\Repositories;

use Modules\Catalog\Entities\CategoryTag;
use Modules\Core\Repositories\EloquentRepository;
use Modules\Core\Repositories\Filters\RelationColumnFilter;
use Spatie\QueryBuilder\AllowedFilter;

class EloquentCategoryTagRepository extends EloquentRepository implements CategoryTagRepository
{
    protected $allowedIncludes = [
        'categories_count'
    ];

    public function __construct(CategoryTag $model)
    {
        parent::__construct($model);
    }

    public function query(array $conditions)
    {
        $query = $this->model->newQuery();

        if (isset($conditions['parent_category_id'])) {
            $query = $query->whereHas('parent_categories', function ($query) use ($conditions) {
                return $query->where('id', $conditions['parent_category_id']);
            });
        }

        return $this->executeQuery($conditions, $query);
    }

    protected function allowedFilters(): array
    {
        return array_merge(parent::allowedFilters(), [
            AllowedFilter::custom('parent_category_id', new RelationColumnFilter('parent_categories', 'id'))
        ]);
    }
}

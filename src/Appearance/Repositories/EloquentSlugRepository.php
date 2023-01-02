<?php

namespace Modules\Appearance\Repositories;

use Modules\Appearance\Entities\Slug;
use Modules\Core\Repositories\EloquentRepository;

class EloquentSlugRepository extends EloquentRepository implements SlugRepository
{
    protected $allowedFilters = [
        'id',
        'slug',
        'slugable_id',
        'slugable_type'
    ];

    protected $allowedIncludes = [
        'slugable'
    ];

    public function __construct(Slug $model)
    {
        parent::__construct($model);
    }

    public function findBySlug($slug)
    {
        return $this->model->newQuery()
            ->where('slug', $slug)
            ->first();
    }

    public function findBySlugWithPrefix($slug, $prefix = null)
    {
        $query = $this->model->newQuery();

        if ($prefix === null) {
            $query->whereNull('prefix');
        } else {
            $query->where('prefix', $prefix);
        }


        return $query->where('slug', $slug)
            ->first();
    }
}

<?php

namespace Modules\Catalog\Repositories;

use Illuminate\Support\Facades\DB;
use Modules\Catalog\Entities\Category;
use Modules\Core\Repositories\EloquentRepository;
use Modules\Core\Repositories\Filters\RelationColumnFilter;
use Spatie\QueryBuilder\AllowedFilter;

class EloquentCategoryRepository extends EloquentRepository implements CategoryRepository
{
    protected $allowedSearch = true;

    protected $allowedFilters = [
        'id',
        'code',
        'name',
        'parent_id'
    ];

    protected $allowedSorts = [
        'id',
        'code',
        'name',
        'parent_id',
        'updated_at',
        'created_at'
    ];

    protected $allowedIncludes = [
        'parent',
        'children',
        'tags',
        'tag_ids',
        'children_tags',
        'children_tags.categories_count',
        'children_tag_ids'
    ];

    public function __construct(Category $model)
    {
        parent::__construct($model);
    }

    public function findByCode($code)
    {
        return $this->model->newQuery()
            ->where('code', $code)
            ->first();
    }

    public function getTrees()
    {
        return $this->model->newQuery()
            ->get()
            ->toTree();
    }

    public function create(array $attributes)
    {
        return DB::transaction(function () use ($attributes) {
            $category = parent::create($attributes);

            if (isset($attributes['slug'])) {
                $category->slug()->create([
                    'prefix' => 'categories',
                    'slug' => $attributes['slug'],
                    'keywords' => $attributes['meta_keywords'] ?? null,
                    'description' => $attributes['meta_description'] ?? null
                ]);
            }

            if (isset($attributes['children_tag_ids'])) {
                $category->children_tags()->attach($attributes['children_tag_ids']);
            }

            if (isset($attributes['tag_ids'])) {
                $category->tag_ids()->attach($attributes['tag_ids']);
            }

            return $category;
        });
    }

    public function update(array $attributes, $id)
    {
        return DB::transaction(function () use ($attributes, $id) {
            $category = parent::update($attributes, $id);

            if (isset($attributes['slug'])) {
                $category->slug()->update([
                    'slug' => $attributes['slug'],
                    'keywords' => $attributes['meta_keywords'] ?? null,
                    'description' => $attributes['meta_description'] ?? null
                ]);
            }

            if (isset($attributes['children_tag_ids'])) {
                $category->children_tags()->sync($attributes['children_tag_ids']);
            }

            if (isset($attributes['tag_ids'])) {
                $category->tag_ids()->sync($attributes['tag_ids']);
            }

            return $category;
        });
    }

    public function delete($id): bool
    {
        return DB::transaction(function () use ($id) {
            $category = parent::find($id);

            $category->slug()->delete();

            return $category->delete();
        });
    }

    protected function allowedFilters(): array
    {
        return array_merge(parent::allowedFilters(), [
            AllowedFilter::scope('root', 'IsRoot'),
            AllowedFilter::custom('tag_id', new RelationColumnFilter('tags', 'id'))
        ]);
    }
}

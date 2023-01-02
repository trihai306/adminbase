<?php

namespace Modules\Catalog\Repositories;

use Illuminate\Support\Facades\DB;
use Modules\Catalog\Entities\Collection;
use Modules\Core\Repositories\EloquentRepository;

class EloquentCollectionRepository extends EloquentRepository implements CollectionRepository
{
    protected $allowedSearch = true;

    protected $allowedFilters = [
        'id',
        'code',
        'name'
    ];

    protected $allowedSorts = [
        'id',
        'code',
        'name',
        'updated_at',
        'created_at'
    ];

    public function __construct(Collection $model)
    {
        parent::__construct($model);
    }

    public function findByCode($code)
    {
        return $this->model->newQuery()
            ->where('code', $code)
            ->first();
    }

    public function create(array $attributes)
    {
        return DB::transaction(function () use ($attributes) {
            $parent = parent::create($attributes);

            if (isset($attributes['slug'])) {
                $parent->slug()->create([
                    'prefix' => 'collections',
                    'slug' => $attributes['slug'],
                    'keywords' => $attributes['meta_keywords'] ?? null,
                    'description' => $attributes['meta_description'] ?? null
                ]);
            }

            return $parent;
        });
    }

    public function update(array $attributes, $id)
    {
        return DB::transaction(function () use ($attributes, $id) {
            $parent = parent::update($attributes, $id);

            if (isset($attributes['slug'])) {
                $parent->slug()->update([
                    'slug' => $attributes['slug'],
                    'keywords' => $attributes['meta_keywords'] ?? null,
                    'description' => $attributes['meta_description'] ?? null
                ]);
            }

            return $parent;
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
}

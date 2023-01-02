<?php

namespace Modules\Core\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Modules\Core\Repositories\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;

class EloquentRepository implements Repository
{
    protected $model;

    protected $allowedSearch = false;
    protected $allowedFilters = [];
    protected $allowedSorts = [];
    protected $allowedIncludes = [];

    private $lockForUpdate = false;

    public function __construct($model)
    {
        $this->model = $model;
    }

    public function query(array $conditions)
    {
        return $this->executeQuery($conditions, $this->newQuery());
    }

    protected function executeQuery(array $conditions, $query = null)
    {
        $query = $this->newQueryBuilder($query);

        if (isset($conditions['id'])) {
            return $query->find($conditions['id']);
        }

        return $query->getOrPaginate();
    }

    public function get(): Collection
    {
        return $this->newQuery()
            ->get();
    }

    public function create(array $attributes)
    {
        return $this->newQuery()
            ->create($attributes);
    }

    public function createMany(array $records, array $additional = [])
    {
        foreach ($records as $record) {
            $this->create(array_merge($record, $additional));
        }
    }

    public function find($id)
    {
        return $this->newQuery()
            ->find($id);
    }

    public function update(array $attributes, $id)
    {
        $model = $this->find($id);

        $model->update($attributes);

        return $model;
    }

    public function delete($id): bool
    {
        return $this->newQuery()
            ->where('id', $id)
            ->delete();
    }

    public function lockForUpdate()
    {
        $this->lockForUpdate = true;

        return $this;
    }

    protected function newQuery()
    {
        $query = $this->model->newQuery();

        if ($this->lockForUpdate) {
            $query->lockForUpdate();
        }

        return $query;
    }

    protected function newQueryBuilder($query = null)
    {
        $queryBuilder = QueryBuilder::for($query ?? $this->model);

        if ($this->allowedSearch) {
            $queryBuilder->allowSearch();
        }

        return $queryBuilder->allowedFilters($this->allowedFilters())
            ->allowedSorts($this->allowedSorts())
            ->allowedIncludes($this->allowedIncludes());
    }

    protected function allowedFilters(): array
    {
        return array_map(function ($column) {
            return AllowedFilter::exact($column);
        }, $this->allowedFilters);
    }

    protected function allowedSorts(): array
    {
        return $this->allowedSorts;
    }

    protected function allowedIncludes(): array
    {
        return $this->allowedIncludes;
    }
}

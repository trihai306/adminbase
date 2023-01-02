<?php

namespace Modules\Core\Repositories\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Spatie\QueryBuilder\Filters\Filter;

class RelationColumnFilter implements Filter
{
    private $relation;
    private $columns;

    public function __construct($relation, $column)
    {
        $this->relation = $relation;
        $this->columns = Arr::wrap($column);
    }

    public function __invoke(Builder $query, $value, string $property)
    {
        $value = Arr::wrap($value);

        return $query->whereHas($this->relation, function ($query) use ($value) {
            return $query->where(function ($query) use ($value) {
                foreach ($this->columns as $column) {
                    $query->orWhereIn($column, $value);
                }
            });
        });
    }
}

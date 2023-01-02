<?php

namespace Modules\Core\Repositories\Filters;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class BetweenColumnFilter implements Filter
{
    private $column;

    public function __construct($column)
    {
        $this->column = $column;
    }

    public function __invoke(Builder $query, $value, string $property)
    {
        return $query->whereBetween($this->column, $value);
    }
}

<?php

namespace Modules\Core\Repositories\Includes;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Includes\IncludeInterface;

class AggregateInclude implements IncludeInterface
{
    protected $column;

    protected $function;

    public function __construct(string $column, string $function)
    {
        $this->column = $column;

        $this->function = $function;
    }

    public function __invoke(Builder $query, $include)
    {
        $query->withAggregate($include, $this->column, $this->function);
    }
}

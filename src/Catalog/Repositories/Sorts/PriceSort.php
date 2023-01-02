<?php

namespace Modules\Catalog\Repositories\Sorts;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Sorts\Sort;

class PriceSort implements Sort
{
    public function __invoke(Builder $query, bool $descending, string $property)
    {
        $direction = $descending ? 'DESC' : 'ASC';

        $query->withMin('default_variant', 'price')
            ->orderBy('default_variant_min_price', $direction);
    }
}

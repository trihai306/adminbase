<?php

namespace Modules\Catalog\Repositories\Filters;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class PriceRangeFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        return $query->whereHas('variants', function ($query) use ($value) {
            list($min, $max) = $value;

            if (is_numeric($min) && is_numeric($max)) {
                return $query->whereBetween('price', [$min, $max]);
            }

            if (is_numeric($min)) {
                return $query->where('price', '>=', $min);
            }

            if (is_numeric($max)) {
                return $query->where('price', '<=', $max);
            }
        });
    }
}

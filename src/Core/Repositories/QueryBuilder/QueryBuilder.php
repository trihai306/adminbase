<?php

namespace Modules\Core\Repositories\QueryBuilder;

use Spatie\QueryBuilder\QueryBuilder as BaseQueryBuilder;

class QueryBuilder extends BaseQueryBuilder
{
    public function allowSearch()
    {
        if ($search = request()->query('search')) {
            $this->getEloquentBuilder()
                ->search($search);
        }

        return $this;
    }

    public function getOrPaginate($perPage = null)
    {
        $perPage = request()->query('per_page', $perPage);

        return $perPage ? $this->paginate($perPage) : $this->get();
    }
}

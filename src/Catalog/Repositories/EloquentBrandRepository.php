<?php

namespace Modules\Catalog\Repositories;

use Modules\Catalog\Entities\Brand;
use Modules\Core\Repositories\EloquentRepository;

class EloquentBrandRepository extends EloquentRepository implements BrandRepository
{
    protected $allowedSearch = true;

    protected $allowedFilters = [
        'id',
        'name'
    ];

    protected $allowedSorts = [
        'id',
        'name',
        'updated_at',
        'created_at'
    ];

    public function __construct(Brand $model)
    {
        parent::__construct($model);
    }
}

<?php

namespace Modules\Catalog\Repositories;

use Modules\Catalog\Entities\Attribute;
use Modules\Core\Repositories\EloquentRepository;

class EloquentAttributeRepository extends EloquentRepository implements AttributeRepository
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

    public function __construct(Attribute $model)
    {
        parent::__construct($model);
    }
}

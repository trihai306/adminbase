<?php

namespace Modules\User\Repositories;

use Spatie\Permission\Models\Permission;
use Modules\Core\Repositories\EloquentRepository;

class EloquentPermissionRepository extends EloquentRepository implements PermissionRepository
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

    public function __construct(Permission $model)
    {
        parent::__construct($model);
    }

    public function getByName(array $names)
    {
        return $this->model->newQuery()
            ->whereIn('name', $names)
            ->get();
    }
}

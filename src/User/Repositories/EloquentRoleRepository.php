<?php

namespace Modules\User\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Modules\User\Entities\Role;
use Modules\Core\Repositories\EloquentRepository;

class EloquentRoleRepository extends EloquentRepository implements RoleRepository
{
    protected $allowedSearch = true;

    protected $allowedFilters = [
        'id',
        'name',
        'is_system',
        'display_name'
    ];

    protected $allowedSorts = [
        'id',
        'name',
        'display_name',
        'updated_at',
        'created_at'
    ];

    protected $allowedIncludes = [
        'permissions',
        'permission_ids'
    ];

    public function __construct(Role $model)
    {
        parent::__construct($model);
    }

    public function query(array $conditions)
    {
        $query = $this->model->newQuery();

        if (isset($conditions['user_id'])) {
            $query->join('model_has_roles', function ($join) {
                    return $join->on('model_has_roles.role_id', '=', 'roles.id')
                        ->where('model_type', 'Modules\\User\\Entities\\User');
                })
                ->where('model_has_roles.model_id', $conditions['user_id']);
        }

        return parent::executeQuery($conditions, $query);
    }

    public function create(array $attributes): Model
    {
        return parent::create(Arr::only($attributes, [
            'name',
            'display_name',
            'is_system'
        ]));
    }

    public function update(array $attributes, $id): Model
    {
        return parent::update(Arr::only($attributes, [
            'name',
            'display_name',
            'is_system'
        ]), $id);
    }
}

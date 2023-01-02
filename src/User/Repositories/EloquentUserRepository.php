<?php

namespace Modules\User\Repositories;

use Illuminate\Support\Facades\DB;
use Modules\Core\Repositories\EloquentRepository;
use Modules\Core\Repositories\Filters\RelationColumnFilter;
use Modules\User\Entities\User;
use Spatie\QueryBuilder\AllowedFilter;

class EloquentUserRepository extends EloquentRepository implements UserRepository
{
    protected $allowedSearch = true;

    protected $allowedFilters = [
        'id',
        'username',
        'password',
        'full_name',
        'email',
        'phone',
        'birthday',
        'is_admin',
        'status'
    ];

    protected $allowedSorts = [
        'id',
        'username',
        'password',
        'full_name',
        'email',
        'phone',
        'birthday',
        'updated_at',
        'created_at'
    ];

    protected $allowedIncludes = [
        'wallet',
        'roles',
        'role_ids',
        'roles.permissions',
        'vouchers'
    ];

    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function findByEmail($email)
    {
        return $this->model->newQuery()
            ->where('email', $email)
            ->first();
    }

    public function create(array $attributes)
    {
        return DB::transaction(function () use ($attributes) {
            $user = parent::create($attributes);

            if (isset($attributes['role_ids'])) {
                $user->assignRole($attributes['role_ids']);
            }

            return $user;
        });
    }

    public function update(array $attributes, $id)
    {
        return DB::transaction(function () use ($attributes, $id) {
            $user = parent::update($attributes, $id);

            if (isset($attributes['role_ids'])) {
                $user->syncRoles($attributes['role_ids']);
            }

            return $user;
        });
    }

    protected function allowedFilters(): array
    {
        return array_merge(parent::allowedFilters(), [
            AllowedFilter::custom(
                'role_id',
                new RelationColumnFilter('roles', 'id')
            ),
        ]);
    }
}

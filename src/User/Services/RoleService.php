<?php

namespace Modules\User\Services;

use Modules\User\Repositories\RoleRepository;

class RoleService
{
    private $roleRepository;

    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    public function create(array $attributes)
    {
        $role = $this->roleRepository->create($attributes);

        if (isset($attributes['permission_ids'])) {
            foreach ($attributes['permission_ids'] as $permission) {
                $role->givePermissionTo($permission);
            }
        }

        return $role;
    }

    public function update(array $attributes, $id)
    {
        $role = $this->roleRepository->update($attributes, $id);

        if (isset($attributes['permission_ids'])) {
            $role->permissions()->detach();
            foreach ($attributes['permission_ids'] as $permission) {
                $role->givePermissionTo($permission);
            }
        }

        return $role;
    }
}

<?php

namespace Modules\User\Controllers\Admin;

use Modules\Core\Controllers\Controller;
use Modules\User\Enums\RolePermission;
use Modules\User\Repositories\RoleRepository;
use Modules\User\Requests\Admin\IndexRoleRequest;
use Modules\User\Requests\Admin\StoreRoleRequest;
use Modules\User\Requests\Admin\UpdateRoleRequest;
use Modules\User\Services\RoleService;
use Modules\User\Transformers\RoleCollection;
use Modules\User\Transformers\RoleResource;

class RoleController extends Controller
{
    private $roleRepository;
    private $roleService;

    public function __construct(
        RoleRepository $roleRepository,
        RoleService $roleService
    ) {
        $this->roleRepository = $roleRepository;
        $this->roleService = $roleService;
    }

    public function index(IndexRoleRequest $request)
    {
        $this->authorize(RolePermission::LIST);

        $roles = $this->roleRepository->query(
            $request->validated()
        );

        return new RoleCollection($roles);
    }

    public function store(StoreRoleRequest $request)
    {
        $this->authorize(RolePermission::CREATE);

        $role = $this->roleService->create($request->validated());

        $role = $this->roleRepository->query([
            'id' => $role->id
        ]);

        return new RoleResource($role);
    }

    public function show($id)
    {
        $role = $this->roleRepository->query([
            'id' => $id
        ]);

        return new RoleResource($role);
    }

    public function update($id, UpdateRoleRequest $request)
    {
        $this->authorize(RolePermission::UPDATE);

        $role = $this->roleRepository->find($id);

        $this->roleService->update($request->validated(), $role->id);

        $role = $this->roleRepository->query([
            'id' => $role->id
        ]);

        return new RoleResource($role);
    }

    public function destroy($id)
    {
        $this->authorize(RolePermission::DELETE);

        $role = $this->roleRepository->find($id);

        if ($role->is_system) {
            return $this->respondError(
                'cant_delete_system_role',
                'Không thể xóa role hệ thống.'
            );
        }

        $this->roleRepository->delete($role->id);

        return $this->respondSuccess('Xóa role thành công.');
    }
}

<?php

namespace Modules\User\Controllers\Admin;

use Modules\Core\Controllers\Controller;
use Modules\User\Enums\UserPermission;
use Modules\User\Repositories\RoleRepository;
use Modules\User\Repositories\UserRepository;
use Modules\User\Requests\Admin\IndexRoleRequest;
use Modules\User\Requests\Admin\StoreUserRoleRequest;
use Modules\User\Transformers\RoleCollection;
use Modules\User\Transformers\RoleResource;

class UserRoleController extends Controller
{
    private $userRepository;
    private $roleRepository;

    public function __construct(
        UserRepository $userRepository,
        RoleRepository $roleRepository
    ) {
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
    }

    public function index($userId, IndexRoleRequest $request)
    {
        $this->authorize(UserPermission::ROLE_LIST);

        $user = $this->userRepository->find($userId);

        $roles = $this->roleRepository->query(
            array_merge($request->validated(), [
                'user_id' => $user->id
            ])
        );

        return new RoleCollection($roles);
    }

    public function store($userId, StoreUserRoleRequest $request)
    {
        $this->authorize(UserPermission::ROLE_CREATE);

        $user = $this->userRepository->find($userId);
        $role = $this->roleRepository->query([
            'id' => $request->input('role_id')
        ]);;

        $user->assignRole($role);

        return new RoleResource($role);
    }

    public function destroy($userId, $roleId)
    {
        $this->authorize(UserPermission::ROLE_DELETE);

        $user = $this->userRepository->find($userId);

        $user->removeRole($roleId);

        return $this->respondSuccess('Xóa role thành công.');
    }
}

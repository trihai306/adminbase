<?php

namespace Modules\User\Controllers\Admin;

use Modules\Core\Controllers\Controller;
use Modules\User\Enums\PermissionPermission;
use Modules\User\Repositories\PermissionRepository;
use Modules\User\Requests\Admin\IndexPermissionRequest;
use Modules\User\Transformers\PermissionCollection;

class PermissionController extends Controller
{
    private $permissionRepository;

    public function __construct(PermissionRepository $permissionRepository)
    {
        $this->permissionRepository = $permissionRepository;
    }

    public function index(IndexPermissionRequest $request)
    {
        $this->authorize(PermissionPermission::LIST);

        $permissions = $this->permissionRepository->query(
            $request->validated()
        );

        return new PermissionCollection($permissions);
    }
}

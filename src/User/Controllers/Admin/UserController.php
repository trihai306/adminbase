<?php

namespace Modules\User\Controllers\Admin;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Core\Controllers\Controller;
use Modules\User\Enums\UserPermission;
use Modules\User\Repositories\UserRepository;
use Modules\User\Requests\Admin\IndexUserRequest;
use Modules\User\Requests\Admin\StoreUserRequest;
use Modules\User\Requests\Admin\UpdateUserRequest;
use Modules\User\Services\UserService;
use Modules\User\Transformers\UserCollection;
use Modules\User\Transformers\UserResource;

class UserController extends Controller
{
    private $userRepository;
    private $userService;

    public function __construct(
        UserRepository $userRepository,
        UserService $userService
    ) {
        $this->userRepository = $userRepository;
        $this->userService = $userService;
    }

    public function index(IndexUserRequest $request): JsonResource
    {
        $this->authorize(UserPermission::LIST);

        $users = $this->userRepository->query(
            $request->validated()
        );

        return new UserCollection($users);
    }

    public function store(StoreUserRequest $request): JsonResource
    {
        $this->authorize(UserPermission::CREATE);

        $user = $this->userService->create($request->validated());

        $user = $this->userRepository->query([
            'id' => $user->id
        ]);

        return new UserResource($user);
    }

    public function show($id): JsonResource
    {
        $this->authorize(UserPermission::DETAIL);

        $user = $this->userRepository->query([
            'id' => $id
        ]);

        return new UserResource($user);
    }

    public function update($id, UpdateUserRequest $request): JsonResource
    {
        $this->authorize(UserPermission::UPDATE);

        $user = $this->userRepository->find($id);

        $this->userService->update($request->validated(), $user->id);

        $user = $this->userRepository->query([
            'id' => $user->id
        ]);

        return new UserResource($user);
    }

    public function destroy($id)
    {
        $this->authorize(UserPermission::DELETE);

        $user = $this->userRepository->find($id);

        $this->userRepository->delete($user->id);

        return $this->respondSuccess('Xóa người dùng thành công.');
    }
}

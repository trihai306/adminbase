<?php

namespace Modules\User\Controllers\Shop;

use Illuminate\Http\Request;
use Modules\Core\Controllers\Controller;
use Modules\User\Repositories\UserRepository;
use Modules\User\Requests\Shop\UpdateMeRequest;
use Modules\User\Services\AuthenticationService;
use Modules\User\Services\UserService;
use Modules\User\Transformers\CustomerResource;

class MeController extends Controller
{
    private $userService;
    private $authenticationService;
    private $userRepository;

    public function __construct(
        UserService $userService,
        AuthenticationService $authenticationService,
        UserRepository $userRepository
    ) {
        $this->userService = $userService;
        $this->authenticationService = $authenticationService;
        $this->userRepository = $userRepository;
    }

    public function show(): CustomerResource
    {
        $user = $this->authenticationService->currentUser();

        $user = $this->userRepository->query([
            'id' => $user->id
        ]);

        return new CustomerResource($user);
    }

    public function update(UpdateMeRequest $request)
    {
        $user = $this->authenticationService->currentUser();

        $this->userService->update($request->validated(), $user->id);

        $user = $this->userRepository->query([
            'id' => $user->id
        ]);

        return new CustomerResource($user);
    }
}

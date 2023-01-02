<?php

namespace Modules\User\Controllers\Admin;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Validation\UnauthorizedException;
use Modules\Core\Controllers\Controller;
use Modules\User\Requests\Admin\StoreTokenRequest;
use Modules\User\Services\AuthenticationService;
use Modules\User\Transformers\TokenResource;

class TokenController extends Controller
{
    private $authenticationService;

    public function __construct(AuthenticationService $authenticationService)
    {
        $this->authenticationService = $authenticationService;
    }

    public function store(StoreTokenRequest $request)
    {
        $account = $request->input('account');
        $password = $request->input('password');

        if (!$this->authenticationService->login($account, $password)) {
            return $this->respondError(
                'invalid_credentials',
                'Tài khoản hoặc mật khẩu không chính xác.'
            );
        }

        $user = $this->authenticationService->currentUser();

        $token = $user->createToken('admin');

        return new TokenResource($token);
    }

    public function destroy()
    {
        $this->authenticationService->logout();

        return $this->respondSuccess('Đăng xuất thành công.');
    }
}

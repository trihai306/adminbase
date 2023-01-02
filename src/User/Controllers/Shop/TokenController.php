<?php

namespace Modules\User\Controllers\Shop;

use Modules\Core\Controllers\Controller;
use Modules\User\Events\UserLoggedIn;
use Modules\User\Requests\Shop\StoreTokenRequest;
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
        $type = $request->input('type');

        if ($this->authenticationService->checkSupportedSocial($type)) {
            $isLogged = $this->authenticationService->loginWithSocial(
                $type,
                $request->input('token')
            );
        } else {
            $isLogged = $this->authenticationService->login(
                $request->input('account'),
                $request->input('password')
            );
        }

        if (!$isLogged) {
            return $this->respondError(
                'invalid_credentials',
                'Tài khoản hoặc mật khẩu không chính xác.'
            );
        }

        $user = $this->authenticationService->currentUser();

        $token = $user->createToken('customer');

        event(new UserLoggedIn($user, $request->ip(), $request->userAgent(), $token));

        return new TokenResource($token);
    }

    public function destroy()
    {
        $this->authenticationService->logout();

        return $this->respondSuccess('Đăng xuất thành công.');
    }
}

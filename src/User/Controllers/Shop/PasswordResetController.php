<?php

namespace Modules\User\Controllers\Shop;

use Illuminate\Auth\Passwords\PasswordBroker;
use Modules\Core\Controllers\Controller;
use Modules\User\Requests\Shop\StorePasswordResetRequest;
use Modules\User\Requests\Shop\UpdatePasswordResetRequest;
use Modules\User\Services\PasswordResetService;

class PasswordResetController extends Controller
{
    private $passwordResetService;

    public function __construct(PasswordResetService $passwordResetService)
    {
        $this->passwordResetService = $passwordResetService;
    }

    public function store(StorePasswordResetRequest $request)
    {
        $result = $this->passwordResetService->sendResetLink(
            $request->only('email')
        );

        if ($result !== PasswordBroker::RESET_LINK_SENT) {
            return $this->respondError(
                'cant_sent_reset_password_link',
                'Không thể gửi đường dẫn thay đổi mật khẩu đến email.'
            );
        }

        return $this->respondSuccess('Đường dẫn đặt lại mật khẩu đã được gửi tới email.');
    }

    public function update($token, UpdatePasswordResetRequest $request)
    {
        $credentials = array_merge($request->validated(), [
            'token' => $token
        ]);

        $result = $this->passwordResetService->reset($credentials);

        if ($result !== PasswordBroker::PASSWORD_RESET) {
            return $this->respondError(
                'cant_reset_password',
                'Không thể đặt lại mật khẩu.'
            );
        }

        return $this->respondSuccess('Đặt lại mật khẩu thành công.');
    }
}

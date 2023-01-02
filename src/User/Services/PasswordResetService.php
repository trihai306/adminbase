<?php

namespace Modules\User\Services;

use Illuminate\Support\Facades\Password;

class PasswordResetService
{
    private $customerService;

    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;
    }

    public function sendResetLink(array $credentials): string
    {
        return Password::sendResetLink($credentials, function ($user, $token) {
            // TODO send reset link to email
        });
    }

    public function reset(array $credentials)
    {
        return Password::reset($credentials, function ($user, $password) {
            $this->customerService->update([
                'password' => $password
            ], $user->id);
        });
    }
}

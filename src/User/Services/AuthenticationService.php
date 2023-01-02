<?php

namespace Modules\User\Services;

use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Modules\Core\Utils\StringUtil;
use Modules\User\Entities\User;
use Modules\User\Repositories\IdentifyProviderConnectionRepository;
use Modules\User\Repositories\IdentifyProviderRepository;
use Modules\User\Repositories\UserRepository;

class AuthenticationService
{
    const SUPPORTED_PROVIDERS = [
        'google',
        'facebook',
        'steam',
        'discord',
        'tiktok'
    ];

    private $userService;
    private $userRepository;
    private $identifyProviderRepository;
    private $identifyProviderConnectionRepository;

    public function __construct(
        UserService $userService,
        UserRepository $userRepository,
        IdentifyProviderRepository $identifyProviderRepository,
        IdentifyProviderConnectionRepository $identifyProviderConnectionRepository
    ) {
        $this->userService = $userService;
        $this->userRepository = $userRepository;
        $this->identifyProviderRepository = $identifyProviderRepository;
        $this->identifyProviderConnectionRepository = $identifyProviderConnectionRepository;
    }

    public function currentUser(): User
    {
        return Auth::user();
    }

    public function login(string $account, string $password): bool
    {
        $credentials = $this->getCredentials($account, $password);

        return Auth::once($credentials);
    }

    public function loginWithSocial($provider, $token): bool
    {
        $identifyProvider = $this->identifyProviderRepository->findByCode($provider);

        if (!$identifyProvider) return false;

        $socialUser = Socialite::driver($provider)
            ->userFromToken($token);

        $identifyProviderConnection = $this->identifyProviderConnectionRepository
            ->findByIdentifyProviderUserId($identifyProvider->id, $socialUser->id);

        if ($identifyProviderConnection) {
            $user = $this->userRepository->find($identifyProviderConnection->user_id);
        } else {
            $user = $this->userRepository->findByEmail($socialUser->email);

            if (!$user) {
                $user = $this->userService->create([
                    'avatar' => $socialUser->avatar,
                    'email' => $socialUser->email,
                    'full_name' => $socialUser->name
                ]);
            }

            $this->identifyProviderConnectionRepository->create([
                'user_id' => $user->id,
                'identify_provider_id' => $identifyProvider->id,
                'identify_provider_user_id' => $socialUser->id
            ]);
        }

        Auth::onceUsingId($user->id);

        return true;
    }

    public function logout(): bool
    {
        $this->currentUser()->currentAccessToken()->delete();

        return true;
    }

    public function getCredentials(string $account, string $password): array
    {
        if (StringUtil::isEmail($account)) {
            $credentials['email'] = $account;
        } else if (StringUtil::isPhone($account)) {
            $credentials['phone'] = $account;
        } else {
            $credentials['username'] = $account;
        }

        $credentials['password'] = $password;

        return $credentials;
    }

    public function checkSupportedSocial($provider): bool
    {
        return in_array($provider, $this->getSupportedSocials());
    }

    public function getSupportedSocials(): array
    {
        return self::SUPPORTED_PROVIDERS;
    }
}

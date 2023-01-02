<?php

namespace Modules\User\Controllers\Shop;

use Laravel\Socialite\Facades\Socialite;
use Modules\Core\Controllers\Controller;
use Modules\User\Entities\IdentifyProvider;
use Modules\User\Repositories\IdentifyProviderConnectionRepository;
use Modules\User\Repositories\IdentifyProviderRepository;
use Modules\User\Requests\Shop\StoreIdentifyProviderRequest;
use Modules\User\Services\AuthenticationService;
use Modules\User\Transformers\IdentifyProviderCollection;
use Modules\User\Transformers\IdentifyProviderResource;

class IdentifyProviderController extends Controller
{
    private $authenticationService;
    private $identifyProviderRepository;
    private $identifyProviderConnectionRepository;

    public function __construct(
        AuthenticationService $authenticationService,
        IdentifyProviderRepository $identifyProviderRepository,
        IdentifyProviderConnectionRepository $identifyProviderConnectionRepository
    )
    {
        $this->authenticationService = $authenticationService;
        $this->identifyProviderRepository = $identifyProviderRepository;
        $this->identifyProviderConnectionRepository = $identifyProviderConnectionRepository;
    }

    public function index()
    {
        $user = $this->authenticationService->currentUser();

        $userIdentifyProviders = $user->identifyProviders->keyBy('id');
        $identifyProviders = IdentifyProvider::all()->map(
            function ($identifyProvider) use ($userIdentifyProviders) {
                $identifyProvider->connected = $userIdentifyProviders->has($identifyProvider->id);

                return $identifyProvider;
            }
        );

        return new IdentifyProviderCollection($identifyProviders);
    }

    public function store(StoreIdentifyProviderRequest $request)
    {
        $user = $this->authenticationService->currentUser();

        $provider = $request->input('provider');
        $identifyProvider = $this->identifyProviderRepository->findByCode($provider);

        $token = $request->input('token');
        $socialUser = Socialite::driver($provider)
            ->userFromToken($token);

        $this->identifyProviderConnectionRepository->create([
            'user_id' => $user->id,
            'identify_provider_id' => $identifyProvider->id,
            'identify_provider_user_id' => $socialUser->id
        ]);

        return new IdentifyProviderResource($identifyProvider);
    }

    public function destroy($id)
    {
        $user = $this->authenticationService->currentUser();

        $identifyProvider = IdentifyProvider::find($id);

        $user->identifyProviders()->detach($identifyProvider->id);

        return $this->respondSuccess('Hủy kết nối thành công.');
    }
}

<?php

namespace Modules\User\Controllers\Shop;

use Modules\Core\Controllers\Controller;
use Modules\User\Repositories\LoginHistoryRepository;
use Modules\User\Services\AuthenticationService;
use Modules\User\Transformers\LoginHistoryCollection;

class LoginHistoryController extends Controller
{
    private $authenticationService;
    private $loginHistoryRepository;

    public function __construct(
        AuthenticationService $authenticationService,
        LoginHistoryRepository $loginHistoryRepository
    )
    {
        $this->authenticationService = $authenticationService;
        $this->loginHistoryRepository = $loginHistoryRepository;
    }

    public function index()
    {
        $user = $this->authenticationService->currentUser();

        $loginHistories = $this->loginHistoryRepository->query([
            'user_id' => $user->id
        ]);

        return new LoginHistoryCollection($loginHistories);
    }
}

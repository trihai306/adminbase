<?php

namespace Modules\Payment\Controllers\Shop;

use Modules\Core\Controllers\Controller;
use Modules\Payment\Repositories\CardExchangeRepository;
use Modules\Payment\Requests\Admin\IndexCardExchangeRequest;
use Modules\Payment\Transformers\CardExchangeCollection;
use Modules\User\Services\AuthenticationService;

class CardExchangeController extends Controller
{
    private $authenticationService;
    private $cardExchangeRepository;

    public function __construct(
        AuthenticationService $authenticationService,
        CardExchangeRepository $cardExchangeRepository
    )
    {
        $this->authenticationService = $authenticationService;
        $this->cardExchangeRepository = $cardExchangeRepository;
    }

    public function index(IndexCardExchangeRequest $request)
    {
        $user = $this->authenticationService->currentUser();

        $cardExchanges = $this->cardExchangeRepository->query(
            array_merge($request->validated(), [
                'user_id' => $user->id
            ])
        );

        return new CardExchangeCollection($cardExchanges);
    }
}

<?php

namespace Modules\User\Controllers\Shop;

use Modules\Core\Controllers\Controller;
use Modules\User\Repositories\TransactionRepository;
use Modules\User\Requests\Admin\IndexTransactionRequest;
use Modules\User\Services\AuthenticationService;
use Modules\User\Transformers\TransactionCollection;

class TransactionController extends Controller
{
    private $transactionRepository;
    private $authenticationService;

    public function __construct(
        TransactionRepository $transactionRepository,
        AuthenticationService $authenticationService
    ) {
        $this->transactionRepository = $transactionRepository;
        $this->authenticationService = $authenticationService;
    }

    public function index(IndexTransactionRequest $request)
    {
        $user = $this->authenticationService->currentUser();

        $transactions = $this->transactionRepository->query(array_merge($request->validated(), [
            'user_id' => $user->id
        ]));

        return new TransactionCollection($transactions);
    }
}

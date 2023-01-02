<?php

namespace Modules\User\Controllers\Admin;

use Modules\Core\Controllers\Controller;
use Modules\User\Repositories\TransactionRepository;
use Modules\User\Requests\Admin\IndexTransactionRequest;
use Modules\User\Transformers\TransactionCollection;

class TransactionController extends Controller
{
    private $transactionRepository;

    public function __construct(TransactionRepository $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }

    public function index(IndexTransactionRequest $request)
    {
        $transactions = $this->transactionRepository->query(
            $request->validated()
        );

        return new TransactionCollection($transactions);
    }
}

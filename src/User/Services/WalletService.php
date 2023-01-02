<?php

namespace Modules\User\Services;

use Illuminate\Support\Facades\DB;
use Modules\User\Events\NewTransaction;
use Modules\User\Repositories\TransactionRepository;
use Modules\User\Repositories\WalletRepository;

class WalletService
{
    private $walletRepository;
    private $transactionRepository;

    public function __construct(
        WalletRepository $walletRepository,
        TransactionRepository $transactionRepository
    ) {
        $this->walletRepository = $walletRepository;
        $this->transactionRepository = $transactionRepository;
    }

    public function deposit($userId, $amount, $content)
    {
        $transaction = DB::transaction(function () use ($userId, $amount, $content) {
            $wallet = $this->walletRepository->findByUserId($userId);

            $this->walletRepository->increaseBalance($userId, $amount);

            return $this->transactionRepository->create([
                'user_id' => $userId,
                'amount' => $amount,
                'balance' => $wallet->balance + $amount,
                'content' => $content
            ]);
        });

        NewTransaction::dispatch($transaction);

        return $transaction;
    }

    public function withdraw($userId, $amount, $content)
    {
        $transaction = DB::transaction(function () use ($userId, $amount, $content) {
            $wallet = $this->walletRepository->findByUserId($userId);

            $this->walletRepository->decreaseBalance($userId, $amount);

            return $this->transactionRepository->create([
                'user_id' => $userId,
                'amount' => -$amount,
                'balance' => $wallet->balance - $amount,
                'content' => $content
            ]);
        });

        NewTransaction::dispatch($transaction);

        return $transaction;
    }
}

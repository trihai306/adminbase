<?php

namespace Modules\User\Controllers\Admin;

use Modules\Core\Controllers\Controller;
use Modules\User\Repositories\WalletRepository;
use Modules\User\Requests\Admin\UpdateUserWalletRequest;
use Modules\User\Services\WalletService;
use Modules\User\Transformers\WalletResource;

class UserWalletController extends Controller
{
    private $walletRepository;
    private $walletService;

    public function __construct(
        WalletRepository $walletRepository,
        WalletService $walletService
    ) {
        $this->walletRepository = $walletRepository;
        $this->walletService = $walletService;
    }

    public function update($userId, UpdateUserWalletRequest $request)
    {
        $wallet = $this->walletRepository->findByUserId($userId);

        if ($request->filled('balance')) {
            $amount = $request->input('balance') - $wallet->balance;

            if ($amount > 0) {
                $this->walletService->deposit($userId, $amount, 'Thay đổi số dư');
            } else {
                $this->walletService->withdraw($userId, -$amount, 'Thay đổi số dư');
            }
        }

        $wallet->refresh();

        return new WalletResource($wallet);
    }
}

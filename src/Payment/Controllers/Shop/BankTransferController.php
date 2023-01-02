<?php

namespace Modules\Payment\Controllers\Shop;

use Modules\Core\Controllers\Controller;
use Modules\Payment\Repositories\BankTransferRepository;
use Modules\Payment\Repositories\CardExchangeRepository;
use Modules\Payment\Requests\Admin\IndexCardExchangeRequest;
use Modules\Payment\Requests\Shop\UpdateBankTransferRequest;
use Modules\Payment\Transformers\BankTransferCollection;
use Modules\Payment\Transformers\BankTransferResource;
use Modules\Payment\Transformers\CardExchangeCollection;
use Modules\User\Services\AuthenticationService;

class BankTransferController extends Controller
{
    private $authenticationService;
    private $bankTransferRepository;

    public function __construct(
        AuthenticationService $authenticationService,
        BankTransferRepository $bankTransferRepository
    )
    {
        $this->authenticationService = $authenticationService;
        $this->bankTransferRepository = $bankTransferRepository;
    }

    public function index(IndexCardExchangeRequest $request)
    {
        $user = $this->authenticationService->currentUser();

        $bankTransfers = $this->bankTransferRepository->query(
            array_merge($request->validated(), [
                'user_id' => $user->id
            ])
        );

        return new BankTransferCollection($bankTransfers);
    }

    public function update($id, UpdateBankTransferRequest $request)
    {
        $user = $this->authenticationService->currentUser();
        $bankTransfer = $this->bankTransferRepository->find($id);

        abort_if($bankTransfer->payment->payer_id !== $user->id, 401);

        $this->bankTransferRepository->update($request->validated(), $bankTransfer->id);

        $bankTransfer = $this->bankTransferRepository->query([
            'id' => $bankTransfer->id
        ]);

        return new BankTransferResource($bankTransfer);
    }
}

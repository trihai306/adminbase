<?php

namespace Modules\Payment\Controllers\Shop;

use Modules\Core\Controllers\Controller;
use Modules\Payment\Repositories\BankTransferRepository;
use Modules\Payment\Repositories\CardExchangeRepository;
use Modules\Payment\Repositories\EwalletTransferRepository;
use Modules\Payment\Requests\Admin\IndexCardExchangeRequest;
use Modules\Payment\Requests\Shop\UpdateEwalletTransferRequest;
use Modules\Payment\Transformers\BankTransferCollection;
use Modules\Payment\Transformers\BankTransferResource;
use Modules\Payment\Transformers\CardExchangeCollection;
use Modules\Payment\Transformers\EwalletTransferCollection;
use Modules\Payment\Transformers\EwalletTransferResource;
use Modules\User\Services\AuthenticationService;

class EwalletTransferController extends Controller
{
    private $authenticationService;
    private $ewalletTransferRepository;

    public function __construct(
        AuthenticationService $authenticationService,
        EwalletTransferRepository $ewalletTransferRepository
    )
    {
        $this->authenticationService = $authenticationService;
        $this->ewalletTransferRepository = $ewalletTransferRepository;
    }

    public function index(IndexCardExchangeRequest $request)
    {
        $user = $this->authenticationService->currentUser();

        $ewalletTransfers = $this->ewalletTransferRepository->query(
            array_merge($request->validated(), [
                'user_id' => $user->id
            ])
        );

        return new EwalletTransferCollection($ewalletTransfers);
    }

    public function update($id, UpdateEwalletTransferRequest $request)
    {
        $user = $this->authenticationService->currentUser();
        $ewalletTransfer = $this->ewalletTransferRepository->find($id);

        abort_if($ewalletTransfer->payment->payer_id !== $user->id, 401);

        $this->ewalletTransferRepository->update($request->validated(), $ewalletTransfer->id);

        $ewalletTransfer = $this->ewalletTransferRepository->query([
            'id' => $ewalletTransfer->id
        ]);

        return new EwalletTransferResource($ewalletTransfer);
    }
}

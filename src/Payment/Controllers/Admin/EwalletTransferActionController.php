<?php

namespace Modules\Payment\Controllers\Admin;

use Modules\Core\Controllers\Controller;
use Modules\Payment\Enums\CardExchangeStatus;
use Modules\Payment\Repositories\BankTransferRepository;
use Modules\Payment\Repositories\CardExchangeRepository;
use Modules\Payment\Repositories\EwalletTransferRepository;
use Modules\Payment\Requests\Admin\DenyBankTransferRequest;
use Modules\Payment\Requests\Admin\DenyCardExchangeRequest;
use Modules\Payment\Requests\Admin\IndexCardExchangeRequest;
use Modules\Payment\Services\BankTransferService;
use Modules\Payment\Services\CardExchangeService;
use Modules\Payment\Services\EwalletTransferService;
use Modules\Payment\Transformers\CardExchangeCollection;
use Modules\Payment\Transformers\CardExchangeResource;

class EwalletTransferActionController extends Controller
{
    private $ewalletTransferRepository;
    private $ewalletTransferService;

    public function __construct(
        EwalletTransferRepository $ewalletTransferRepository,
        EwalletTransferService $ewalletTransferService
    )
    {
        $this->ewalletTransferRepository = $ewalletTransferRepository;
        $this->ewalletTransferService = $ewalletTransferService;
    }

    public function accept($ewalletTransferId)
    {
        $ewalletTransfer = $this->ewalletTransferRepository->find($ewalletTransferId);

        $this->ewalletTransferService->accept($ewalletTransfer);

        return $this->respondSuccess('Chấp nhận thẻ thành công.');
    }

    public function deny($ewalletTransferId, DenyBankTransferRequest $request)
    {
        $ewalletTransfer = $this->ewalletTransferRepository->find($ewalletTransferId);

        $this->ewalletTransferService->deny($ewalletTransfer, $request->input('feedback'));

        return $this->respondSuccess('Từ chối thẻ thành công.');
    }
}

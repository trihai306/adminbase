<?php

namespace Modules\Payment\Controllers\Admin;

use Modules\Core\Controllers\Controller;
use Modules\Payment\Enums\CardExchangeStatus;
use Modules\Payment\Repositories\BankTransferRepository;
use Modules\Payment\Repositories\CardExchangeRepository;
use Modules\Payment\Requests\Admin\DenyBankTransferRequest;
use Modules\Payment\Requests\Admin\DenyCardExchangeRequest;
use Modules\Payment\Requests\Admin\IndexCardExchangeRequest;
use Modules\Payment\Services\BankTransferService;
use Modules\Payment\Services\CardExchangeService;
use Modules\Payment\Transformers\CardExchangeCollection;
use Modules\Payment\Transformers\CardExchangeResource;

class BankTransferActionController extends Controller
{
    private $bankTransferRepository;
    private $bankTransferService;

    public function __construct(
        BankTransferRepository $bankTransferRepository,
        BankTransferService $bankTransferService
    )
    {
        $this->bankTransferRepository = $bankTransferRepository;
        $this->bankTransferService = $bankTransferService;
    }

    public function accept($bankTransferId)
    {
        $cardExchange = $this->bankTransferRepository->find($bankTransferId);

        $this->bankTransferService->accept($cardExchange);

        return $this->respondSuccess('Chấp nhận thẻ thành công.');
    }

    public function deny($bankTransferId, DenyBankTransferRequest $request)
    {
        $cardExchange = $this->bankTransferRepository->find($bankTransferId);

        $this->bankTransferService->deny($cardExchange, $request->input('feedback'));

        return $this->respondSuccess('Từ chối thẻ thành công.');
    }
}

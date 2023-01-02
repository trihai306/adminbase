<?php

namespace Modules\Payment\Controllers\Callbacks;

use Modules\Core\Controllers\Controller;
use Modules\Payment\Requests\Callback\BankTransferCallbackRequest;
use Modules\Payment\Requests\Callback\CardExchangeCallbackRequest;
use Modules\Payment\Requests\Callback\EwalletTransferCallbackRequest;
use Modules\Payment\Services\BankTransferService;
use Modules\Payment\Services\CardExchangeService;
use Modules\Payment\Services\EwalletTransferService;

class PaymentCallbackController extends Controller
{
    private $bankTransferService;
    private $ewalletTransferService;
    private $cardExchangeService;

    public function __construct(
        BankTransferService $bankTransferService,
        EwalletTransferService $ewalletTransferService,
        CardExchangeService $cardExchangeService
    ) {
        $this->bankTransferService = $bankTransferService;
        $this->ewalletTransferService = $ewalletTransferService;
        $this->cardExchangeService = $cardExchangeService;
    }

    public function handleBankTransferCallback(BankTransferCallbackRequest $request)
    {
        $data = $request->validated();
        $apiKey = config('payments.bank_transfer.api_key');
        $hash = md5($apiKey.$data['ref'].$data['date'].$data['content'].$data['amount']);

        abort_if($hash !== $data['hash'], 401);

        $this->bankTransferService->callback($request->validated());

        return $this->respondSuccess('Hoàn thành thanh toán.');
    }

    public function handleEwalletTransferCallback(EwalletTransferCallbackRequest $request)
    {
        $this->ewalletTransferService->callback($request->validated());

        return $this->respondSuccess('Hoàn thành thanh toán.');
    }

    public function handleCardExchangeCallback(CardExchangeCallbackRequest $request)
    {
        $data = $request->validated();
        $apiKey = config('payments.dtsr.api_key');
        $hash = md5($apiKey.$data['Pin'].$data['Seri']);

        abort_if($hash !== $data['Hash'], 401);

        $this->cardExchangeService->callback($data);

        return $this->respondSuccess('Hoàn thành thanh toán.');
    }
}

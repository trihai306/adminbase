<?php

namespace Modules\Payment\Controllers\Admin;

use Modules\Core\Controllers\Controller;
use Modules\Payment\Repositories\BankTransferRepository;
use Modules\Payment\Repositories\EwalletTransferRepository;
use Modules\Payment\Requests\Admin\IndexBankTransferRequest;
use Modules\Payment\Transformers\BankTransferCollection;
use Modules\Payment\Transformers\EwalletTransferCollection;

class EwalletTransferController extends Controller
{
    private $ewalletTransferRepository;

    public function __construct(EwalletTransferRepository $ewalletTransferRepository)
    {
        $this->ewalletTransferRepository = $ewalletTransferRepository;
    }

    public function index(IndexBankTransferRequest $request)
    {
        $ewalletTransfers = $this->ewalletTransferRepository->query(
            $request->validated()
        );

        return new EwalletTransferCollection($ewalletTransfers);
    }
}

<?php

namespace Modules\Payment\Controllers\Admin;

use Modules\Core\Controllers\Controller;
use Modules\Payment\Repositories\BankTransferRepository;
use Modules\Payment\Requests\Admin\IndexBankTransferRequest;
use Modules\Payment\Transformers\BankTransferCollection;

class BankTransferController extends Controller
{
    private $bankTransferRepository;

    public function __construct(BankTransferRepository $bankTransferRepository)
    {
        $this->bankTransferRepository = $bankTransferRepository;
    }

    public function index(IndexBankTransferRequest $request)
    {
        $bankTransfers = $this->bankTransferRepository->query(
            $request->validated()
        );

        return new BankTransferCollection($bankTransfers);
    }
}

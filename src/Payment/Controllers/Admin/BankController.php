<?php

namespace Modules\Payment\Controllers\Admin;

use Modules\Core\Controllers\Controller;
use Modules\Payment\Repositories\BankRepository;
use Modules\Payment\Requests\Admin\IndexBankRequest;
use Modules\Payment\Requests\Admin\StoreBankRequest;
use Modules\Payment\Transformers\BankCollection;
use Modules\Payment\Transformers\BankResource;

class BankController extends Controller
{
    private $bankRepository;

    public function __construct(BankRepository $bankRepository)
    {
        $this->bankRepository = $bankRepository;
    }

    public function index(IndexBankRequest $request)
    {
        $banks = $this->bankRepository->query($request->validated());

        return new BankCollection($banks);
    }

    public function store(StoreBankRequest $request)
    {
        $bank = $this->bankRepository->create($request->validated());

        $bank = $this->bankRepository->query([
            'id' => $bank->id
        ]);

        return new BankResource($bank);
    }

    public function update($id, StoreBankRequest $request)
    {
        $bank = $this->bankRepository->update($request->validated(), $id);

        $bank = $this->bankRepository->query([
            'id' => $bank->id
        ]);

        return new BankResource($bank);
    }

    public function destroy($id)
    {
        $bank = $this->bankRepository->find($id);

        $this->bankRepository->delete($bank->id);

        return $this->respondSuccess('Xóa ngân hàng thành công.');
    }
}

<?php

namespace Modules\Catalog\Controllers\Shop;


use Modules\Catalog\Repositories\VoucherRepository;
use Modules\Catalog\Requests\Admin\IndexProductRequest;
use Modules\Catalog\Services\VoucherService;
use Modules\Catalog\Transformers\HistoryPointResource;
use Modules\Catalog\Transformers\VoucherCollection;
use Modules\Catalog\Transformers\VoucherResource;
use Modules\Core\Controllers\Controller;
use Modules\User\Services\AuthenticationService;

class VoucherController extends Controller
{
    private $voucherRepository;
    private $voucherService;
    private $authenticationService;

    public function __construct(
        VoucherRepository     $voucherRepository,
        VoucherService        $voucherService,
        AuthenticationService $authenticationService
    )
    {
        $this->voucherRepository = $voucherRepository;
        $this->voucherService = $voucherService;
        $this->authenticationService = $authenticationService;
    }

    public function index(IndexProductRequest $request)
    {
        $data = $request->validated();

        $data[] = ['user_id' => $this->authenticationService->currentUser()->id];
        $data[] = ['min_quality', 1];
        $voucher = $this->voucherRepository->query(
            $data
        );
        return new VoucherCollection($voucher);
    }

    public function show($id)
    {
        $voucher = $this->voucherRepository->query(compact('id'));
        return new VoucherResource($voucher);
    }

    public function userByVoucher($id)
    {
        $history = $this->voucherService->byVoucher($id);
        return new HistoryPointResource($history);

    }

    public function listVoucherExchange(IndexProductRequest $request)
    {
        $data = $request->validated();
        $voucher = $this->voucherRepository->query(
            $data
        );

        return new VoucherCollection($voucher);
    }
}

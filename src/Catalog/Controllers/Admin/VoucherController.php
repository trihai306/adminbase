<?php

namespace Modules\Catalog\Controllers\Admin;



use Modules\Catalog\Repositories\VoucherRepository;
use Modules\Catalog\Requests\Admin\IndexProductRequest;
use Modules\Catalog\Requests\Admin\IndexVoucherRequest;
use Modules\Catalog\Requests\Admin\StoreVoucherRequest;
use Modules\Catalog\Requests\Admin\UpdateVoucherRequest;
use Modules\Catalog\Services\VoucherService;
use Modules\Catalog\Transformers\VoucherCollection;
use Modules\Catalog\Transformers\VoucherResource;
use Modules\Core\Controllers\Controller;

class VoucherController extends Controller
{
    private $voucherRepository;
    private $voucherService;

    public function __construct(
        VoucherRepository $voucherRepository,
        VoucherService    $voucherService
    )
    {
        $this->voucherRepository = $voucherRepository;
        $this->voucherService = $voucherService;
    }

    public function index(IndexVoucherRequest $request)
    {
        $voucher = $this->voucherRepository->query(
            $request->validated()
        );

        return new VoucherCollection($voucher);
    }

    public function store(StoreVoucherRequest $request)
    {

        $voucher = $this->voucherService->create(
            $request->validated()
        );

        $voucher = $this->voucherRepository->query([
            'id' => $voucher->id
        ]);

        return new VoucherResource($voucher);

    }

    public function show($id)
    {
        $voucher = $this->voucherRepository->query(compact('id'));
        return new VoucherResource($voucher);
    }

    public function update($id, UpdateVoucherRequest $request)
    {

        if (empty($voucher = $this->voucherRepository->find($id))) {
            return $this->respondError('', 'id không tồn tại');
        }
        $this->voucherService->update(
            $request->validated(),
            $voucher->id
        );

        $voucher = $this->voucherRepository->query([
            'id' => $voucher->id
        ]);

        return new VoucherResource($voucher);
    }

    public function destroy($id)
    {
        if (empty($voucher = $this->voucherRepository->find($id))) {
            return $this->respondError('', 'id không tồn tại');
        }
        $this->voucherRepository->delete($voucher->id);

        return $this->respondSuccess('Xóa voucher thành công.');
    }


}

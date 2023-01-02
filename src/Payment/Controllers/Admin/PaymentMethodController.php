<?php

namespace Modules\Payment\Controllers\Admin;

use Modules\Core\Controllers\Controller;
use Modules\Payment\Repositories\PaymentMethodRepository;
use Modules\Payment\Requests\Admin\IndexPaymentMethodRequest;
use Modules\Payment\Requests\Admin\StorePaymentMethodRequest;
use Modules\Payment\Requests\Admin\UpdatePaymentMethodRequest;
use Modules\Payment\Services\PaymentMethodService;
use Modules\Payment\Transformers\PaymentMethodCollection;
use Modules\Payment\Transformers\PaymentMethodResource;

class PaymentMethodController extends Controller
{
    private $paymentMethodRepository;
    private $paymentMethodService;

    public function __construct(
        PaymentMethodRepository $paymentMethodRepository,
        PaymentMethodService $paymentMethodService
    ) {
        $this->paymentMethodRepository = $paymentMethodRepository;
        $this->paymentMethodService = $paymentMethodService;
    }

    public function index(IndexPaymentMethodRequest $request)
    {
        $paymentMethods = $this->paymentMethodRepository->query(
            $request->validated()
        );

        return new PaymentMethodCollection($paymentMethods);
    }

    public function store(StorePaymentMethodRequest $request)
    {
        $paymentMethod = $this->paymentMethodService->create(
            $request->validated()
        );

        $paymentMethod = $this->paymentMethodRepository->query([
            'id' => $paymentMethod->id
        ]);

        return new PaymentMethodResource($paymentMethod);
    }

    public function show($id)
    {
        $paymentMethod = $this->paymentMethodRepository->find($id) ??
            $this->paymentMethodRepository->findByCode($id);

        $paymentMethod = $this->paymentMethodRepository->query([
            'id' => $paymentMethod->id
        ]);

        return new PaymentMethodResource($paymentMethod);
    }

    public function update($id, UpdatePaymentMethodRequest $request)
    {
        $paymentMethod = $this->paymentMethodRepository->find($id);

        $this->paymentMethodService->update(
            $request->validated(),
            $paymentMethod->id
        );

        $paymentMethod = $this->paymentMethodRepository->query([
            'id' => $paymentMethod->id
        ]);

        return new PaymentMethodResource($paymentMethod);
    }

    public function destroy($id)
    {
        $paymentMethod = $this->paymentMethodRepository->find($id);

        $this->paymentMethodRepository->delete($paymentMethod->id);

        return $this->respondSuccess('Xóa phương thức thanh toán thành công.');
    }
}

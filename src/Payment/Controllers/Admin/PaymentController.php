<?php

namespace Modules\Payment\Controllers\Admin;

use Modules\Core\Controllers\Controller;
use Modules\Payment\Enums\PaymentPermission;
use Modules\Payment\Enums\PaymentStatus;
use Modules\Payment\Repositories\PaymentRepository;
use Modules\Payment\Requests\Admin\IndexPaymentRequest;
use Modules\Payment\Services\PaymentService;
use Modules\Payment\Transformers\PaymentCollection;
use Modules\Payment\Transformers\PaymentResource;
use Modules\User\Services\AuthenticationService;

class PaymentController extends Controller
{
    private $paymentRepository;
    private $authenticationService;
    private $paymentService;

    public function __construct(
        PaymentRepository $paymentRepository,
        AuthenticationService $authenticationService,
        PaymentService $paymentService
    ) {
        $this->paymentRepository = $paymentRepository;
        $this->authenticationService = $authenticationService;
        $this->paymentService = $paymentService;
    }

    public function index(IndexPaymentRequest $request)
    {
        $this->authorize(PaymentPermission::LIST);

        $payments = $this->paymentRepository->query(
            $request->validated()
        );

        return new PaymentCollection($payments);
    }

    public function show($id)
    {
        $this->authorize(PaymentPermission::DETAIL);

        $payment = $this->paymentRepository->query([
            'id' => $id
        ]);

        return new PaymentResource($payment);
    }

    public function complete($id)
    {
        $user = $this->authenticationService->currentUser();
        $payment = $this->paymentRepository->find($id);

        if (!$payment->canComplete()) {
            return $this->respondError(
                'cant_complete_payment',
                'Không thể hoàn thành thanh toán.'
            );
        }

        $this->paymentService->complete($payment->id, $user->id);

        $payment = $this->paymentRepository->query([
            'id' => $payment->id
        ]);

        return new PaymentResource($payment);
    }

    public function cancel($id)
    {
        $user = $this->authenticationService->currentUser();
        $payment = $this->paymentRepository->find($id);

        if (!$payment->canCancel()) {
            return $this->respondError(
                'cant_cancel_payment',
                'Không thể hủy thanh toán.'
            );
        }

        $this->paymentService->cancel($payment->id, $user->id);

        $payment = $this->paymentRepository->query([
            'id' => $payment->id
        ]);

        return new PaymentResource($payment);
    }
}

<?php

namespace Modules\Payment\Controllers\Shop;

use Modules\Core\Controllers\Controller;
use Modules\Payment\Enums\PaymentStatus;
use Modules\Payment\Repositories\PaymentMethodRepository;
use Modules\Payment\Repositories\PaymentRepository;
use Modules\Payment\Requests\Admin\IndexPaymentMethodRequest;
use Modules\Payment\Requests\Shop\StorePaymentRequest;
use Modules\Payment\Services\PaymentService;
use Modules\Payment\Transformers\PaymentCollection;
use Modules\Payment\Transformers\PaymentResource;
use Modules\User\Services\AuthenticationService;

class PaymentController extends Controller
{
    private $paymentService;
    private $authenticationService;
    private $paymentRepository;
    private $paymentMethodRepository;

    public function __construct(
        PaymentService $paymentService,
        AuthenticationService $authenticationService,
        PaymentRepository $paymentRepository,
        PaymentMethodRepository $paymentMethodRepository
    ) {
        $this->paymentService = $paymentService;
        $this->authenticationService = $authenticationService;
        $this->paymentRepository = $paymentRepository;
        $this->paymentMethodRepository = $paymentMethodRepository;
    }

    public function index(IndexPaymentMethodRequest $request)
    {
        $user = $this->authenticationService->currentUser();

        $payments = $this->paymentRepository->query(array_merge($request->validated(), [
            'payer_id' => $user->id
        ]));

        return new PaymentCollection($payments);
    }

    public function store(StorePaymentRequest $request)
    {
        $user = $this->authenticationService->currentUser();

        $payment = $this->paymentService->create(array_merge($request->validated(), [
            'payer_id' => $user->id,
            'status' => PaymentStatus::PENDING
        ]));

        $payment = $this->paymentRepository->query([
            'id' => $payment->id
        ]);

        return new PaymentResource($payment);
    }

    public function show($id)
    {
        $user = $this->authenticationService->currentUser();

        $payment = $this->paymentRepository->query([
            'id' => $id,
            'payer_id' => $user->id
        ]);

        return new PaymentResource($payment);
    }
}

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

class PaymentActionController extends Controller
{
    private $paymentService;
    private $authenticationService;
    private $paymentRepository;

    public function __construct(
        PaymentService $paymentService,
        AuthenticationService $authenticationService,
        PaymentRepository $paymentRepository
    ) {
        $this->paymentService = $paymentService;
        $this->authenticationService = $authenticationService;
        $this->paymentRepository = $paymentRepository;
    }

    public function cancel($id)
    {
        $user = $this->authenticationService->currentUser();
        $payment = $this->paymentRepository->find($id);

        abort_if($payment->payer_id !== $user->id, 401);

        $this->paymentService->cancel($payment);

        return $this->respondSuccess('Hủy thanh toán thành công.');
    }
}

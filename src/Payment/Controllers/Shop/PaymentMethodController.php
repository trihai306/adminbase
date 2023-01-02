<?php

namespace Modules\Payment\Controllers\Shop;

use Modules\Core\Controllers\Controller;
use Modules\Payment\Repositories\PaymentMethodRepository;
use Modules\Payment\Transformers\PaymentMethodCollection;
use Modules\Payment\Transformers\PaymentMethodResource;

class PaymentMethodController extends Controller
{
    private $paymentMethodRepository;

    public function __construct(PaymentMethodRepository $paymentMethodRepository)
    {
        $this->paymentMethodRepository = $paymentMethodRepository;
    }

    public function index()
    {
        $paymentMethods = $this->paymentMethodRepository->query([
            'enabled' => true
        ]);

        return new PaymentMethodCollection($paymentMethods);
    }

    public function show($id)
    {
        $paymentMethod = $this->paymentMethodRepository->find($id) ??
            $this->paymentMethodRepository->findByCode($id);

        $paymentMethod = $this->paymentMethodRepository->query([
            'id' => $paymentMethod->id,
            'enabled' => true
        ]);

        return new PaymentMethodResource($paymentMethod);
    }
}

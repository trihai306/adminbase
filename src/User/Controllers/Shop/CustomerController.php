<?php

namespace Modules\User\Controllers\Shop;

use Modules\User\Repositories\UserRepository;
use Modules\User\Requests\Shop\StoreCustomerRequest;
use Modules\User\Services\CustomerService;
use Modules\User\Transformers\CustomerResource;
use Modules\User\Transformers\TokenResource;

class CustomerController
{
    private $customerService;
    private $userRepository;

    public function __construct(
        CustomerService $customerService,
        UserRepository $userRepository
    ) {
        $this->customerService = $customerService;
        $this->userRepository = $userRepository;
    }

    public function store(StoreCustomerRequest $request): CustomerResource
    {
        $customer = $this->customerService->create(
            $request->validated()
        );

        $token = $customer->createToken('customer');

        $customer = $this->userRepository->query([
            'id' => $customer->id
        ]);

        return (new CustomerResource($customer))->additional([
            'token' => new TokenResource($token)
        ]);
    }
}

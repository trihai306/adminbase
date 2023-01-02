<?php

namespace Modules\Order\Controllers\Shop;

use Modules\Core\Controllers\Controller;
use Modules\Order\Repositories\OrderItemRepository;
use Modules\Order\Requests\Shop\IndexOrderItemRequest;
use Modules\Order\Transformers\OrderItemCollection;
use Modules\Order\Transformers\OrderItemResource;
use Modules\User\Services\AuthenticationService;

class OrderItemController extends Controller
{
    private $orderItemRepository;
    private $authenticationService;

    public function __construct(
        OrderItemRepository $orderItemRepository,
        AuthenticationService $authenticationService
    ) {
        $this->orderItemRepository = $orderItemRepository;
        $this->authenticationService = $authenticationService;
    }

    public function index(IndexOrderItemRequest $request)
    {
        $user = $this->authenticationService->currentUser();

        $orderItems = $this->orderItemRepository->query(
            array_merge($request->validated(), [
                'buyer_id' => $user->id
            ])
        );

        return new OrderItemCollection($orderItems);
    }

    public function show($id)
    {
        $orderItem = $this->orderItemRepository->query([
            'id' => $id
        ]);

        return new OrderItemResource($orderItem);
    }
}

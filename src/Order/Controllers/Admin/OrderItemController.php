<?php

namespace Modules\Order\Controllers\Admin;

use Modules\Core\Controllers\Controller;
use Modules\Order\Repositories\OrderItemRepository;
use Modules\Order\Requests\Admin\IndexOrderItemRequest;
use Modules\Order\Transformers\OrderItemCollection;
use Modules\Order\Transformers\OrderItemResource;

class OrderItemController extends Controller
{
    private $orderItemRepository;

    public function __construct(OrderItemRepository $orderItemRepository)
    {
        $this->orderItemRepository = $orderItemRepository;
    }

    public function index(IndexOrderItemRequest $request)
    {
        $orderItems = $this->orderItemRepository->query(
            $request->validated()
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

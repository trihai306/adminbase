<?php

namespace Modules\Order\Controllers\Admin;

use Modules\Core\Controllers\Controller;
use Modules\Order\Repositories\OrderRepository;
use Modules\Order\Requests\Admin\IndexOrderRequest;
use Modules\Order\Transformers\OrderCollection;
use Modules\Order\Transformers\OrderResource;

class OrderController extends Controller
{
    private $orderRepository;

    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function index(IndexOrderRequest $request)
    {
        $orders = $this->orderRepository->query(
            $request->validated()
        );

        return new OrderCollection($orders);
    }

    public function show($id)
    {
        $order = $this->orderRepository->query([
            'id' => $id
        ]);

        return new OrderResource($order);
    }
}

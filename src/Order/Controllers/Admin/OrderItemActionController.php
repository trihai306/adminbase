<?php

namespace Modules\Order\Controllers\Admin;

use Illuminate\Http\Request;
use Modules\Core\Controllers\Controller;
use Modules\Order\Enums\OrderItemStatus;
use Modules\Order\Repositories\OrderItemRepository;
use Modules\Order\Requests\Admin\CancelOrderItemRequest;
use Modules\Order\Requests\Admin\StoreDeliveryOrderItemRequest;
use Modules\Order\Services\DeliveryOrderItemService;
use Modules\Order\Services\OrderItemService;
use Modules\Order\Transformers\DeliveryOrderItemCollection;
use Modules\Order\Transformers\OrderItemResource;

class OrderItemActionController extends Controller
{
    private $orderItemRepository;
    private $orderItemService;
    private $deliveryOrderItemService;

    public function __construct(
        OrderItemRepository $orderItemRepository,
        OrderItemService $orderItemService,
        DeliveryOrderItemService $deliveryOrderItemService
    )
    {
        $this->orderItemRepository = $orderItemRepository;
        $this->orderItemService = $orderItemService;
        $this->deliveryOrderItemService = $deliveryOrderItemService;
    }

    public function process($id, Request $request)
    {
        $orderItem = $this->orderItemRepository->find($id);

        if (
            $orderItem->status->value !== OrderItemStatus::NEW &&
            $orderItem->status->value !== OrderItemStatus::PENDING
        ) {
            return $this->respondError(
                'dont_process_order_item',
                'Đơn hàng không được xử lý.',
                401
            );
        }

        $this->orderItemService->process($orderItem->id);

        $orderItem = $this->orderItemRepository->query([
            'id' => $orderItem->id
        ]);

        return new OrderItemResource($orderItem);
    }

    public function delivery($id, StoreDeliveryOrderItemRequest $request)
    {
        $orderItem = $this->orderItemRepository->find($id);

        if ($orderItem->status->value !== OrderItemStatus::DELIVERING) {
            return $this->respondError(
                'dont_delivery_order_item',
                'Đơn hàng không được giao.',
                401
            );
        }

        $this->deliveryOrderItemService->create(
            array_merge($request->validated(), [
                'order_item_id' => $orderItem->id
            ])
        );

        $orderItem = $this->orderItemRepository->query([
            'id' => $orderItem->id
        ]);

        return new OrderItemResource($orderItem);
    }

    public function cancel($id, CancelOrderItemRequest $request)
    {
        $orderItem = $this->orderItemRepository->find($id);

        $this->orderItemService->cancel($orderItem->id, $request->input('feedback'));

        $orderItem = $this->orderItemRepository->query([
            'id' => $orderItem->id
        ]);

        return new OrderItemResource($orderItem);
    }

    public function complete($id, Request $request)
    {
        $orderItem = $this->orderItemRepository->find($id);

        if ($orderItem->status->value !== OrderItemStatus::DELIVERING) {
            return $this->respondError(
                'dont_process_order_item',
                'Đơn hàng không được hoàn thành.',
                401
            );
        }

        $this->orderItemService->complete($orderItem->id);

        $orderItem = $this->orderItemRepository->query([
            'id' => $orderItem->id
        ]);

        return new OrderItemResource($orderItem);
    }
}

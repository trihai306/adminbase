<?php

namespace Modules\Order\Controllers\Admin;

use Modules\Core\Controllers\Controller;
use Modules\Order\Enums\OrderItemStatus;
use Modules\Order\Repositories\DeliveryInventoryItemRepository;
use Modules\Order\Repositories\OrderItemRepository;
use Modules\Order\Requests\Admin\IndexDeliveryOrderItemRequest;
use Modules\Order\Requests\Admin\StoreDeliveryOrderItemRequest;
use Modules\Order\Services\DeliveryOrderItemService;
use Modules\Order\Transformers\DeliveryOrderItemCollection;

class OrderDeliveryInventoryItemController extends Controller
{
    private $orderItemRepository;
    private $deliveryInventoryItemRepository;
    private $deliveryOrderItemService;

    public function __construct(
        OrderItemRepository $orderItemRepository,
        DeliveryInventoryItemRepository $deliveryInventoryItemRepository,
        DeliveryOrderItemService $deliveryOrderItemService
    )
    {
        $this->orderItemRepository = $orderItemRepository;
        $this->deliveryInventoryItemRepository = $deliveryInventoryItemRepository;
        $this->deliveryOrderItemService = $deliveryOrderItemService;
    }

    public function index($orderItemId, IndexDeliveryOrderItemRequest $request)
    {
        $deliveryOrderItems = $this->deliveryInventoryItemRepository->query(
             array_merge($request->validated(), [
                 'order_item_id' => $orderItemId
             ])
        );

        return new DeliveryOrderItemCollection($deliveryOrderItems);
    }

    public function store($orderItemId, StoreDeliveryOrderItemRequest $request)
    {
        $orderItem = $this->orderItemRepository->find($orderItemId);

        if ($orderItem->status->value !== OrderItemStatus::DELIVERING) {
            return $this->respondError('dont_delivery_order_item', 'Đơn hàng không được giao.', 401);
        }

        $deliveryOrderItems = $this->deliveryOrderItemService->create(
            array_merge($request->validated(), [
                'order_item_id' => $orderItem->id
            ])
        );

        return new DeliveryOrderItemCollection($deliveryOrderItems);
    }
}

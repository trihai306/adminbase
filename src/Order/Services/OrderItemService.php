<?php

namespace Modules\Order\Services;

use Illuminate\Support\Facades\DB;
use Modules\Inventory\Enums\InventoryItemStatus;
use Modules\Inventory\Repositories\InventoryItemRepository;
use Modules\Order\Enums\OrderItemStatus;
use Modules\Order\Enums\OrderStatus;
use Modules\Order\Events\OrderItemCanceled;
use Modules\Order\Events\OrderItemCompleted;
use Modules\Order\Repositories\DeliveryInventoryItemRepository;
use Modules\Order\Repositories\OrderItemRepository;
use Modules\Order\Repositories\OrderRepository;
use Modules\User\Services\UserService;
use Modules\User\Services\WalletService;

class OrderItemService
{
    private $inventoryItemRepository;
    private $deliveryInventoryItemRepository;
    private $orderItemRepository;
    private $orderRepository;
    private $walletService;
    private $userService;
    public function __construct(
        InventoryItemRepository $inventoryItemRepository,
        DeliveryInventoryItemRepository $deliveryInventoryItemRepository,
        OrderItemRepository $orderItemRepository,
        OrderRepository $orderRepository,
        WalletService $walletService,
        UserService $userService
    )
    {
        $this->inventoryItemRepository = $inventoryItemRepository;
        $this->deliveryInventoryItemRepository = $deliveryInventoryItemRepository;
        $this->orderItemRepository = $orderItemRepository;
        $this->orderRepository = $orderRepository;
        $this->walletService = $walletService;
        $this->userService = $userService;
    }

    public function process($orderItemId)
    {
      return DB::transaction(function () use ($orderItemId){
          $order = $this->orderItemRepository->update([
              'status' => OrderItemStatus::DELIVERING
          ], $orderItemId);
      });
    }

    public function cancel($orderItemId, $feedback = null)
    {
        $this->orderItemRepository->update([
            'feedback' => $feedback,
            'status' => OrderItemStatus::CANCELED
        ], $orderItemId);
    }

    public function complete($orderItemId)
    {
       $order = $this->orderItemRepository->update([
            'status' => OrderItemStatus::COMPLETED
        ], $orderItemId);
        $this->userService->update(['points'=>$order->total],$order->buyer_id);
    }

    public function delivery($orderItemId)
    {
        return DB::transaction(function () use ($orderItemId) {
            $orderItem = $this->orderItemRepository->find($orderItemId);

            $this->orderItemRepository->update([
                'status' => OrderItemStatus::DELIVERING
            ], $orderItem->id);

            $this->orderRepository->update([
                'status' => OrderStatus::DELIVERING
            ], $orderItem->order_id);

            $inventoryItems = $this->inventoryItemRepository->getDeliveringInventoryItems(
                $orderItem->variant_id,
                $orderItem->quantity
            );

            if ($inventoryItems->count() == $orderItem->quantity) {
                foreach ($inventoryItems as $inventoryItem) {
                    $this->deliverInventoryItem($orderItem->id, $inventoryItem->id, $inventoryItem->item);
                }

                $order = $this->orderItemRepository->update([
                    'status' => OrderItemStatus::COMPLETED
                ], $orderItem->id);
                $this->userService->update(['points'=>$order->total],$order->buyer_id);

                OrderItemCompleted::dispatch($orderItem);
            } else {
                $this->orderItemRepository->update([
                    'status' => OrderItemStatus::CANCELED
                ], $orderItem->id);

                $this->walletService->deposit(
                    $orderItem->order->buyer_id,
                    $orderItem->sale_price,
                    'Hoàn tiền đơn hàng'
                );

                OrderItemCanceled::dispatch($orderItem);
            }
        });
    }

    protected function deliverInventoryItem($orderItemId, $inventoryItemId, $item)
    {
        return DB::transaction(function () use ($orderItemId, $inventoryItemId, $item) {
            $this->deliveryInventoryItemRepository->create([
                'order_item_id' => $orderItemId,
                'inventory_item_id' => $inventoryItemId,
                'item' => $item
            ]);

            $this->inventoryItemRepository->update([
                'status' => InventoryItemStatus::SOLD
            ], $inventoryItemId);
        });
    }
}

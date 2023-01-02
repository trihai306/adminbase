<?php

namespace Modules\Order\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Modules\Order\Entities\OrderItem;
use Modules\Order\Enums\OrderItemStatus;
use Modules\Order\Services\OrderItemService;

class DeliverOrderItem implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $orderItem;

    public function __construct(OrderItem $orderItem)
    {
        $this->orderItem = $orderItem;
    }

    public function handle(
        OrderItemService $orderItemService
    )
    {
        $orderItem = $this->orderItem;

        if ($orderItem->status->value !== OrderItemStatus::PENDING) {
            return;
        }

        $orderItemService->delivery($orderItem->id);
    }

    public function uniqueId()
    {
        return $this->orderItem->id;
    }
}

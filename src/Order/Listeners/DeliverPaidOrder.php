<?php

namespace Modules\Order\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Order\Enums\OrderStatus;
use Modules\Order\Jobs\DeliverOrderItem;

class DeliverPaidOrder implements ShouldQueue
{
    public $afterCommit = true;

    public function handle($event)
    {
        $order = $event->order;

        if ($order->status->value !== OrderStatus::PENDING) {
            return;
        }

        foreach ($order->items as $item) {
            if ($item->shouldDeliverImmediate()) {
                DeliverOrderItem::dispatch($item);
            }
        }
    }
}

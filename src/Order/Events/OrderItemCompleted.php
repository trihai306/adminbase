<?php

namespace Modules\Order\Events;

use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Modules\Order\Entities\OrderItem;

class OrderItemCompleted
{
    use SerializesModels, Dispatchable;

    public $orderItem;

    public function __construct(OrderItem $orderItem)
    {
        $this->orderItem = $orderItem;
    }

    public function broadcastOn()
    {
        return [];
    }

}

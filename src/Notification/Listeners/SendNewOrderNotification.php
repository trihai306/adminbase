<?php

namespace Modules\Notification\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Notification\Services\NotificationService;
use Modules\Order\Events\NewOrder;
use Modules\Notification\Notifications\NewOrder as NewOrderNotification;

class SendNewOrderNotification implements ShouldQueue
{
    private $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function handle(NewOrder $event)
    {
        $this->notificationService->send(
            $event->order->buyer,
            new NewOrderNotification($event->order)
        );
    }
}

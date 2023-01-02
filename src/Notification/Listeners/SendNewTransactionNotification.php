<?php

namespace Modules\Notification\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Notification\Services\NotificationService;
use Modules\User\Events\NewTransaction;
use Modules\Notification\Notifications\NewTransaction as NewTransactionNotification;

class SendNewTransactionNotification implements ShouldQueue
{
    private $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function handle(NewTransaction $event)
    {
        $this->notificationService->send(
            $event->transaction->user,
            new NewTransactionNotification($event->transaction)
        );
    }
}

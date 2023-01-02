<?php

namespace Modules\Notification\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Notification\Services\NotificationService;
use Modules\User\Events\NewVerificationCode;
use Modules\Notification\Notifications\NewVerificationCode as NewVerificationCodeNotification;

class SendNewVerificationCodeNotification implements ShouldQueue
{
    private $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function handle(NewVerificationCode $event)
    {
        $this->notificationService->sendRoute(
            'mail',
            $event->email,
            new NewVerificationCodeNotification($event->action, $event->email, $event->code, $event->domain)
        );
    }
}

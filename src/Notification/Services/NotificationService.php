<?php

namespace Modules\Notification\Services;

use Modules\Notification\Entities\Notification;
use Illuminate\Support\Facades\Notification as NotificationSender;

class NotificationService
{
    public function send($recipients, $notification)
    {
        NotificationSender::send($recipients, $notification);
    }

    public function sendNow($recipients, $notification)
    {
        NotificationSender::sendNow($recipients, $notification);
    }

    public function sendRoute($route, $address, $notification)
    {
        NotificationSender::route($route, $address)->notify($notification);
    }

    public function makeMessage(Notification $notification)
    {
        if (
            !class_exists($notification->type) ||
            !method_exists($notification->type, 'toMessage')
        ) {
            return;
        }

        try {
            return $notification->type::toMessage($notification->data);
        } catch (\Exception $exception) {
            return null;
        }
    }
}

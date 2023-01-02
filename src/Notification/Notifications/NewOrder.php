<?php

namespace Modules\Notification\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Modules\Order\Entities\Order;

class NewOrder extends Notification implements ShouldQueue
{
    use Queueable;

    private $order;

    public function __construct(Order $order)
    {
        $this->order = $order;

    }

    public function via($notifiable)
    {
        return [
            'mail',
            'database',
            'broadcast'
        ];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line("Đơn hàng #{$this->order->id}.");
    }

    public function toDatabase($notifiable)
    {
        return [
            'order_id' => $this->order->id,
            'total' => $this->order->total
        ];
    }

    public function toBroadcast($notifiable)
    {
        $data = [
            'order_id' => $this->order->id,
            'total' => $this->order->total
        ];

        return new BroadcastMessage([
            'message' => static::toMessage($data),
            'data' => $data
        ]);
    }

    public static function toMessage($data)
    {
        return __('Đơn hàng :order_id', [
            'order_id' => $data['order_id']
        ]);
    }
}

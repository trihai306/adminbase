<?php

namespace Modules\Notification\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\User\Entities\Transaction;

class NewTransaction extends Notification implements ShouldQueue
{
    use Queueable;

    private $transaction;

    public static $message;

    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    public function via($notifiable): array
    {
        return [
            'database',
            'broadcast'
        ];
    }

    public function toDatabase($notifiable)
    {
        return [
            'amount' => $this->transaction->amount,
            'balance' => $this->transaction->balance,
            'content' => $this->transaction->content
        ];
    }

    public function toBroadcast($notifiable)
    {
        $data = [
            'amount' => $this->transaction->amount,
            'balance' => $this->transaction->balance,
            'content' => $this->transaction->content
        ];

        return new BroadcastMessage([
            'message' => static::toMessage($data),
            'data' => $data
        ]);
    }

    public static function toMessage($data)
    {
        return __('Giao dịch :amount với nội dung :content', [
            'amount' => number_format($data['amount'], 0, '', ',').'đ',
            'content' => $data['content']
        ]);
    }
}

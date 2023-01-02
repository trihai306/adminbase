<?php

namespace Modules\Payment\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Modules\Payment\Entities\Payment;

class PaymentCompleted implements ShouldBroadcast
{
    use SerializesModels, Dispatchable;

    public $payment;

    public function __construct(Payment $payment)
    {
        $this->payment = $payment;
    }

    public function broadcastOn()
    {
        $paymentId = $this->payment->id;

        return [
            new Channel("shop.payments.$paymentId")
        ];
    }

    public function broadcastAs()
    {
        return 'payment-completed';
    }
}

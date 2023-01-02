<?php

namespace Modules\Payment\Events;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Modules\Payment\Entities\CardExchange;
use Modules\Payment\Transformers\CardExchangeResource;

class CardExchangeEvent
{
    use SerializesModels, Dispatchable;

    public $cardExchange;

    public function __construct(CardExchange $cardExchange)
    {
        $this->cardExchange = $cardExchange;
    }

    public function broadcastOn()
    {
        $cardExchangeId = $this->cardExchange->id;
        $payerId = $this->cardExchange->payment->payer_id;

        return [
            new PrivateChannel("shop.$payerId.card-exchanges"),
            new PrivateChannel("shop.$cardExchangeId"),
            new PrivateChannel("admin.$payerId.card-exchanges"),
            new PrivateChannel("admin.$cardExchangeId")
        ];
    }

    public function broadcastWith()
    {
        return [
            'cardExchange' => (new CardExchangeResource($this->cardExchange))
                ->toArray(request())
        ];
    }

    public function broadcastAs()
    {
        return 'card-exchange-processing';
    }
}

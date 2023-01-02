<?php

namespace Modules\Inbox\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Modules\Inbox\Entities\Message;
use Modules\Inbox\Transformers\MessageResource;

class NewMessage implements ShouldBroadcast
{
    use SerializesModels;
    use Dispatchable;

    public $message;

    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    public function broadcastOn()
    {
        $threadId = $this->message->thread_id;

        return [
            new Channel("admin.inbox"),
            new PrivateChannel("admin.threads.$threadId"),
            new PrivateChannel("shop.threads.$threadId")
        ];
    }

    public function broadcastWith()
    {
        $this->message->loadMissing('sender');

        return [
            'message' => (new MessageResource($this->message))
                ->toArray(request())
        ];
    }

    public function broadcastAs()
    {
        return 'new-message';
    }
}

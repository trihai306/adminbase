<?php

namespace Modules\Inbox\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Order\Transformers\OrderItemResource;
use Modules\Order\Transformers\OrderResource;
use Modules\User\Transformers\UserResource;

class ThreadResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'subject' => $this->subject,
            'customer_id' => $this->customer_id,
            'customer' => $this->whenLoaded('customer', function () {
                return new UserResource($this->customer);
            }),
            'participants' => $this->whenLoaded('participants', function () {
                return SenderResource::collection($this->participants);
            }),
            'messages' => $this->whenLoaded('messages', function () {
                return MessageResource::collection($this->messages);
            }),
            'latest_message' => $this->whenLoaded('latest_message', function () {
                return new MessageResource($this->latest_message);
            }),
            'order_item_id' => $this->order_item_id,
            'order_item' => $this->whenLoaded('order_item', function () {
                return new OrderItemResource($this->order_item);
            }),
            'last_seen_at' => $this->last_seen_at,
            'unseen_messages_count' => $this->unseen_messages_count,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at
        ];
    }
}

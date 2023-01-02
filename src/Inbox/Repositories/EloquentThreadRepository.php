<?php

namespace Modules\Inbox\Repositories;

use Illuminate\Support\Facades\DB;
use Modules\Core\Repositories\EloquentRepository;
use Modules\Inbox\Entities\Thread;

class EloquentThreadRepository extends EloquentRepository implements ThreadRepository
{
    protected $allowedSearch = true;

    protected $allowedFilters = [
        'id',
        'subject',
        'customer_id',
        'order_item_id'
    ];

    protected $allowedSorts = [
        'id',
        'subject',
        'customer_id',
        'order_item_id',
        'updated_at',
        'created_at'
    ];

    protected $allowedIncludes = [
        'customer',
        'order_item',
        'participants',
        'latest_message',
        'latest_message.participant',
        'messages',
        'messages.participant'
    ];

    public function __construct(Thread $model)
    {
        parent::__construct($model);
    }

    public function findByOrderItemId($orderItemId)
    {
        return $this->model->newQuery()
            ->where('order_item_id', $orderItemId)
            ->first();
    }

    public function create(array $attributes)
    {
        return DB::transaction(function () use ($attributes) {
            $thread = parent::create($attributes);

            if (isset($attributes['participant_ids'])) {
                $thread->participants()->attach($attributes['participant_ids']);
            }

            return $thread;
        });
    }

    public function markLastSeen($threadId, $participantId)
    {
        return DB::table('thread_participant')
            ->where('thread_id', $threadId)
            ->where('user_id', $participantId)
            ->update(['last_seen_at' => now()]);
    }

    public function checkInParticipant($threadId, $userId)
    {
        return DB::table('thread_participant')
            ->where('thread_id', $threadId)
            ->where('user_id', $userId)
            ->exists();
    }
}

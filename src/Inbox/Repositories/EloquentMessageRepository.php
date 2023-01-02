<?php

namespace Modules\Inbox\Repositories;

use Modules\Core\Repositories\EloquentRepository;
use Modules\Inbox\Entities\Message;

class EloquentMessageRepository extends EloquentRepository implements MessageRepository
{
    protected $allowedSearch = true;

    protected $allowedFilters = [
        'thread_id',
        'sender_id'
    ];

    protected $allowedSorts = [
        'id',
        'thread_id',
        'sender_id',
        'updated_at',
        'created_at'
    ];

    protected $allowedIncludes = [
        'sender'
    ];

    public function __construct(Message $model)
    {
        parent::__construct($model);
    }

    public function query(array $conditions)
    {
        $query = $this->model->newQuery();

        if (isset($conditions['thread_id'])) {
            $query->where('thread_id', $conditions['thread_id']);
        }

        return $this->executeQuery($conditions, $query);
    }
}

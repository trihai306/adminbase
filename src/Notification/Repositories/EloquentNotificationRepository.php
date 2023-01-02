<?php

namespace Modules\Notification\Repositories;

use Modules\Core\Repositories\EloquentRepository;
use Modules\Core\Repositories\QueryBuilder\QueryBuilder;
use Modules\Notification\Entities\Notification;
use Modules\User\Entities\User;

class EloquentNotificationRepository extends EloquentRepository implements NotificationRepository
{
    protected $allowedSorts = [
        'id',
        'read_at',
        'updated_at',
        'created_at'
    ];

    public function __construct(Notification $model)
    {
        parent::__construct($model);
    }

    public function query(array $conditions)
    {
        $query = $this->newQueryBuilder();

        if (isset($conditions['user_id'])) {
            $query->where('notifiable_id', $conditions['user_id'])
                ->where('notifiable_type', User::class);
        }

        return $query->getOrPaginate();
    }

    public function markAsRead($ids)
    {
        return $this->model->newQuery()
            ->whereIn('id', $ids)
            ->markAsRead();
    }

    public function countUnRead($userId)
    {
        return $this->model->newQuery()
            ->where('notifiable_id', $userId)
            ->where('notifiable_type', User::class)
            ->whereNull('read_at')
            ->count();
    }
}

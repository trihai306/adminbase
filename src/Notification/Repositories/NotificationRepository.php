<?php

namespace Modules\Notification\Repositories;

use Modules\Core\Repositories\Repository;

interface NotificationRepository extends Repository
{
    public function query(array $conditions);
    public function markAsRead($ids);
    public function countUnRead($userId);
}

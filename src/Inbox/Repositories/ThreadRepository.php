<?php

namespace Modules\Inbox\Repositories;

use Modules\Core\Repositories\Repository;

interface ThreadRepository extends Repository
{
    public function findByOrderItemId($orderItemId);
    public function markLastSeen($threadId, $participantId);
    public function checkInParticipant($threadId, $userId);
}

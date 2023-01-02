<?php

namespace Modules\User\Repositories;

use Modules\Core\Repositories\Repository;

interface UserRepository extends Repository
{
    public function findByEmail($email);
}

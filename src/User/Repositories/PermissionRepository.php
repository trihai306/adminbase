<?php

namespace Modules\User\Repositories;

use Modules\Core\Repositories\Repository;

interface PermissionRepository extends Repository
{
    public function query(array $conditions);
    public function getByName(array $names);
}

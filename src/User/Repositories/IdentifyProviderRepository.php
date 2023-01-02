<?php

namespace Modules\User\Repositories;

use Modules\Core\Repositories\Repository;

interface IdentifyProviderRepository extends Repository
{
    public function findByCode($code);
}

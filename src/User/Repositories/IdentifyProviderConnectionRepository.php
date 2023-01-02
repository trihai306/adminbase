<?php

namespace Modules\User\Repositories;

use Modules\Core\Repositories\Repository;

interface IdentifyProviderConnectionRepository extends Repository
{
    public function findByIdentifyProviderUserId($identifyProviderId, $identifyProviderUserId);
}

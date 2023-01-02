<?php

namespace Modules\User\Repositories;

use Modules\Core\Repositories\EloquentRepository;
use Modules\User\Entities\IdentifyProviderConnection;

class EloquentIdentifyProviderConnectionRepository extends EloquentRepository implements IdentifyProviderConnectionRepository
{
    public function __construct(IdentifyProviderConnection $model)
    {
        parent::__construct($model);
    }

    public function findByIdentifyProviderUserId($identifyProviderId, $identifyProviderUserId)
    {
        return $this->model->newQuery()
            ->where('identify_provider_id', $identifyProviderId)
            ->where('identify_provider_user_id', $identifyProviderUserId)
            ->first();
    }
}

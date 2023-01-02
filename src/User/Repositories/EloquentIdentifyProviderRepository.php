<?php

namespace Modules\User\Repositories;

use Modules\Core\Repositories\EloquentRepository;
use Modules\User\Entities\IdentifyProvider;

class EloquentIdentifyProviderRepository extends EloquentRepository implements IdentifyProviderRepository
{
    public function __construct(IdentifyProvider $model)
    {
        parent::__construct($model);
    }

    public function findByCode($code)
    {
        return $this->model->newQuery()
            ->where('code', $code)
            ->first();
    }
}

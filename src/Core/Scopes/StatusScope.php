<?php

namespace Modules\Core\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class StatusScope implements Scope
{
    private $allowedStatus;

    public function __construct($allowedStatus)
    {
        $this->allowedStatus = $allowedStatus;
    }

    public function apply(Builder $builder, Model $model)
    {
        $builder->where('status', $this->allowedStatus);
    }
}

<?php

namespace Modules\Catalog\Repositories;

use Modules\Catalog\Entities\Brand;
use Modules\Catalog\Entities\HistoryPoint;
use Modules\Catalog\Entities\Voucher;
use Modules\Core\Repositories\EloquentRepository;

class EloquentHistoryPointRepository extends EloquentRepository implements HistoryPointRepository
{
    protected $allowedSearch = true;

    protected $allowedFilters = [
        'id',
        'point',

    ];

    protected $allowedSorts = [
        'id',
        'point',
        'status',
        'note',
        'updated_at',
        'created_at'
    ];
    protected $allowedIncludes = [
        'users'
    ];

    public function __construct(HistoryPoint $model)
    {
        parent::__construct($model);
    }
    public function query(array $conditions){
        $query = $this->model->newQuery();
        if (isset($conditions[0]['user_id'])) {
            $query = $query->whereHas('users', function ($query) use ($conditions) {
                return $query->where('user_id', $conditions[0]['user_id']);
            });
        }
        return $this->executeQuery($conditions, $query);
    }
}

<?php

namespace Modules\Payment\Repositories;

use Modules\Core\Repositories\EloquentRepository;
use Modules\Payment\Entities\EwalletTransfer;

class EloquentEwalletTransferRepository extends EloquentRepository implements EwalletTransferRepository
{
    protected $allowedSearch = true;

    protected $allowedFilters = [
        'ref',
        'content',
        'amount',
        'status'
    ];

    protected $allowedSorts = [
        'id',
        'ref',
        'content',
        'amount',
        'status',
        'updated_at',
        'created_at'
    ];

    protected $allowedIncludes = [
        'ewallet'
    ];

    public function __construct(EwalletTransfer $model)
    {
        parent::__construct($model);
    }

    public function query(array $conditions)
    {
        $query = $this->model->newQuery();

        if (isset($conditions['user_id'])) {
            $query->join('payments', 'payments.id', 'ewallet_transfers.payment_id')
                ->where('payer_id', $conditions['user_id'])
                ->select('ewallet_transfers.*');
        }

        return parent::executeQuery($conditions, $query);
    }
}

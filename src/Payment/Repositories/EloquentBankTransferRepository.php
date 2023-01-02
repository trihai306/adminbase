<?php

namespace Modules\Payment\Repositories;

use Modules\Core\Repositories\EloquentRepository;
use Modules\Payment\Entities\BankTransfer;

class EloquentBankTransferRepository extends EloquentRepository implements BankTransferRepository
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
        'bank'
    ];

    public function __construct(BankTransfer $model)
    {
        parent::__construct($model);
    }

    public function query(array $conditions)
    {
        $query = $this->model->newQuery();

        if (isset($conditions['user_id'])) {
            $query->join('payments', 'payments.id', 'bank_transfers.payment_id')
                ->where('payer_id', $conditions['user_id'])
                ->select('bank_transfers.*');
        }

        return parent::executeQuery($conditions, $query);
    }

    public function findByPaymentId($paymendId)
    {
        return $this->newQuery()
            ->where('payment_id', $paymendId)
            ->first();
    }
}

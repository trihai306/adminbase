<?php

namespace Modules\Payment\Repositories;

use Modules\Core\Repositories\EloquentRepository;
use Modules\Core\Repositories\QueryBuilder\QueryBuilder;
use Modules\Payment\Entities\Payment;

class EloquentPaymentRepository extends EloquentRepository implements PaymentRepository
{
    protected $allowedSearch = true;

    protected $allowedFilters = [
        'id',
        'payer_id',
        'type',
        'method_id',
        'method_type',
        'amount',
        'discount_rate',
        'verifier_id',
        'verified_at',
        'status'
    ];

    protected $allowedSorts = [
        'id',
        'payer_id',
        'type',
        'method_id',
        'method_type',
        'amount',
        'discount_rate',
        'verifier_id',
        'verified_at',
        'status',
        'updated_at',
        'created_at'
    ];

    protected $allowedIncludes = [
        'payer',
        'method',
        'method.banks',
        'method.cards',
        'verifier',
        'card_exchange',
        'card_exchange.card',
        'bank_transfer',
        'bank_transfer.bank',
        'ewallet_transfer',
        'ewallet_transfer.ewallet'
    ];

    public function __construct(Payment $model)
    {
        parent::__construct($model);
    }

    public function query(array $conditions)
    {
        $query = $this->model->newQuery();

        if (isset($conditions['payer_id'])) {
            $query->where('payer_id', $conditions['payer_id']);
        }

        return parent::executeQuery($conditions, $query);
    }
}

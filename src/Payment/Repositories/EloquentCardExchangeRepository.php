<?php

namespace Modules\Payment\Repositories;

use Modules\Core\Repositories\EloquentRepository;
use Modules\Payment\Entities\CardExchange;

class EloquentCardExchangeRepository extends EloquentRepository implements CardExchangeRepository
{
    protected $allowedSearch = true;

    protected $allowedFilters = [
        'id',
        'payment_id',
        'card_id',
        'type',
        'serial',
        'code',
        'value',
        'amount',
        'status'
    ];

    protected $allowedSorts = [
        'id',
        'payment_id',
        'card_id',
        'type',
        'serial',
        'code',
        'value',
        'amount',
        'status',
        'updated_at',
        'created_at'
    ];

    protected $allowedIncludes = [
        'card'
    ];

    public function __construct(CardExchange $model)
    {
        parent::__construct($model);
    }

    public function query(array $conditions)
    {
        $query = $this->model->newQuery();

        if (isset($conditions['user_id'])) {
            $query->join('payments', 'payments.id', 'card_exchanges.payment_id')
                ->where('payer_id', $conditions['user_id'])
                ->select('card_exchanges.*');
        }

        return parent::executeQuery($conditions, $query);
    }
}

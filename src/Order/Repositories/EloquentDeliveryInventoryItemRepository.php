<?php

namespace Modules\Order\Repositories;

use Modules\Core\Repositories\EloquentRepository;
use Modules\Order\Entities\DeliveryInventoryItem;

class EloquentDeliveryInventoryItemRepository extends EloquentRepository implements DeliveryInventoryItemRepository
{
    public function __construct(DeliveryInventoryItem $model)
    {
        parent::__construct($model);
    }

    public function query(array $conditions)
    {
        $query = $this->model->newQuery();

        if (isset($conditions['order_item_id'])) {
            $query = $query->where('order_item_id', $conditions['order_item_id']);
        }

        return $this->executeQuery($conditions, $query);
    }

}

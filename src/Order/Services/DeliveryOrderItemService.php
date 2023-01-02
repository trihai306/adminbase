<?php

namespace Modules\Order\Services;

use Illuminate\Support\Facades\DB;
use Modules\Order\Repositories\DeliveryInventoryItemRepository;

class DeliveryOrderItemService
{
    private $deliveryInventoryItemRepository;

    public function __construct(
        DeliveryInventoryItemRepository $deliveryInventoryItemRepository
    )
    {
        $this->deliveryInventoryItemRepository = $deliveryInventoryItemRepository;
    }

    public function create($attributes)
    {
        return DB::transaction(function () use ($attributes) {
            $deliveryInventoryItems = [];

            if (isset($attributes['item'])) {
                $deliveryInventoryItems[] = $this->deliveryInventoryItemRepository->create($attributes);
            }

            if (isset($attributes['items'])) {
                foreach ($attributes['items'] as $item) {
                    $deliveryInventoryItems[] = $this->deliveryInventoryItemRepository->create(
                        array_merge($attributes, ['item' => $item])
                    );
                }
            }

            return $deliveryInventoryItems;
        });
    }
}

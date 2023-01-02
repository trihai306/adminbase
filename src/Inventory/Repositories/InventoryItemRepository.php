<?php

namespace Modules\Inventory\Repositories;

use Modules\Core\Repositories\Repository;

interface InventoryItemRepository extends Repository
{
    public function getDeliveringInventoryItems($inventoryId, $quantity);
}

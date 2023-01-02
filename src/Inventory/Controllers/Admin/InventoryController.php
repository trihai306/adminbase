<?php

namespace Modules\Inventory\Controllers\Admin;

use Modules\Core\Controllers\Controller;
use Modules\Inventory\Repositories\InventoryRepository;
use Modules\Inventory\Requests\Admin\IndexInventoryRequest;
use Modules\Inventory\Transformers\InventoryCollection;

class InventoryController extends Controller
{
    private $inventoryRepository;

    public function __construct(InventoryRepository $inventoryRepository)
    {
        $this->inventoryRepository = $inventoryRepository;
    }

    public function index(IndexInventoryRequest $request)
    {
        $inventories = $this->inventoryRepository->query(
            $request->validated()
        );

        return new InventoryCollection($inventories);
    }
}

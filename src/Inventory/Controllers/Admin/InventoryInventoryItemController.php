<?php

namespace Modules\Inventory\Controllers\Admin;

use Modules\Core\Controllers\Controller;
use Modules\Inventory\Enums\InventoryItemStatus;
use Modules\Inventory\Repositories\InventoryItemRepository;
use Modules\Inventory\Repositories\InventoryRepository;
use Modules\Inventory\Requests\Admin\StoreInventoryInventoryItemRequest;
use Modules\Inventory\Transformers\InventoryResource;
use Modules\User\Services\AuthenticationService;

class InventoryInventoryItemController extends Controller
{
    private $authenticationService;
    private $inventoryRepository;
    private $inventoryItemRepository;

    public function __construct(
        AuthenticationService $authenticationService,
        InventoryRepository $inventoryRepository,
        InventoryItemRepository $inventoryItemRepository
    ) {
        $this->authenticationService = $authenticationService;
        $this->inventoryRepository = $inventoryRepository;
        $this->inventoryItemRepository = $inventoryItemRepository;
    }

    public function store($id, StoreInventoryInventoryItemRequest $request)
    {
        $user = $this->authenticationService->currentUser();
        $inventory = $this->inventoryRepository->find($id);

        foreach ($request->input('items') as $item) {
            $this->inventoryItemRepository->create([
                'inventory_id' => $inventory->id,
                'item' => $item,
                'importer_id' => $user->id,
                'status' => $request->input('status', InventoryItemStatus::AVAILABLE)
            ]);
        }

        $inventory = $this->inventoryRepository->query([
            'id' => $inventory->id
        ]);

        return new InventoryResource($inventory);
    }
}

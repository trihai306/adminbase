<?php

namespace Modules\Inventory\Controllers\Admin;

use Modules\Core\Controllers\Controller;
use Modules\Inventory\Repositories\InventoryItemRepository;
use Modules\Inventory\Requests\Admin\IndexInventoryItemRequest;
use Modules\Inventory\Requests\Admin\StoreInventoryItemRequest;
use Modules\Inventory\Requests\Admin\UpdateInventoryItemRequest;
use Modules\Inventory\Transformers\InventoryItemCollection;
use Modules\Inventory\Transformers\InventoryItemResource;
use Modules\User\Services\AuthenticationService;

class InventoryItemController extends Controller
{
    private $authenticationService;
    private $inventoryItemRepository;

    public function __construct(
        AuthenticationService $authenticationService,
        InventoryItemRepository $inventoryItemRepository
    ) {
        $this->authenticationService = $authenticationService;
        $this->inventoryItemRepository = $inventoryItemRepository;
    }

    public function index(IndexInventoryItemRequest $request)
    {
        $inventoryItems = $this->inventoryItemRepository->query(
            $request->validated()
        );

        return new InventoryItemCollection($inventoryItems);
    }

    public function store(StoreInventoryItemRequest $request)
    {
        $user = $this->authenticationService->currentUser();

        $inventoryItem = $this->inventoryItemRepository->create(
            array_merge($request->validated(), [
                'importer_id' => $user->id
            ])
        );

        $inventoryItem = $this->inventoryItemRepository->query([
            'id' => $inventoryItem->id
        ]);

        return new InventoryItemResource($inventoryItem);
    }

    public function update($id, UpdateInventoryItemRequest $request)
    {
        $inventoryItem = $this->inventoryItemRepository->find($id);

        $this->inventoryItemRepository->update($request->validated(), $inventoryItem->id);

        $inventoryItem = $this->inventoryItemRepository->query([
            'id' => $inventoryItem->id
        ]);

        return new InventoryItemResource($inventoryItem);
    }

    public function destroy($id)
    {
        $inventoryItem = $this->inventoryItemRepository->find($id);

        $this->inventoryItemRepository->delete($inventoryItem->id);

        return $this->respondSuccess('Xóa kho thành công.');
    }
}

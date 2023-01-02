<?php

namespace Modules\Inventory\Controllers\Admin;

use Illuminate\Http\Request;
use Modules\Core\Controllers\Controller;
use Modules\Inventory\Repositories\InventoryItemRepository;

class BulkInventoryItemController extends Controller
{
    private $inventoryItemRepository;

    public function __construct(
        InventoryItemRepository $inventoryItemRepository
    ) {
        $this->inventoryItemRepository = $inventoryItemRepository;
    }

    public function destroy(Request $request)
    {
        foreach ($request->input('ids') as $id) {
            $this->inventoryItemRepository->delete($id);
        }

        return $this->respondSuccess('Xóa kho thành công.');
    }
}

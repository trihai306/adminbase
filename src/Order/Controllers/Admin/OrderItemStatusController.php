<?php

namespace Modules\Order\Controllers\Admin;

use Illuminate\Http\Request;
use Modules\Core\Controllers\Controller;
use Modules\Order\Enums\OrderItemStatus;
use Modules\Order\Transformers\OrderStatusCollection;

class OrderItemStatusController extends Controller
{
    public function index(Request $request)
    {
        $orderStatuses = collect(OrderItemStatus::getKeys())
            ->map(function ($key) {
                return OrderItemStatus::fromKey($key);
            });

        $codes = $request->query('filter')['code'] ?? null;
        if ($codes) {
            $orderStatuses = $orderStatuses->whereIn('value', explode(',',  $codes));
        }

        return new OrderStatusCollection($orderStatuses);
    }
}

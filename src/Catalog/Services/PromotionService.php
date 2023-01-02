<?php

namespace Modules\Catalog\Services;

use Illuminate\Support\Facades\DB;
use Modules\Catalog\Entities\Promotion;
use Modules\Catalog\Entities\Variant;
use Modules\Catalog\Enums\PromotionActionType;
use Modules\Catalog\Enums\PromotionScopeType;

class PromotionService
{
    public function apply(Promotion $promotion)
    {
        if ($promotion->scope_type == PromotionScopeType::PRODUCT) {
            $productIds = $promotion->products()
                ->pluck('id');
            $query = Variant::whereIn('product_id',$productIds->toArray())
                ->whereNull('discount_price');
            if ($promotion->action_type == PromotionActionType::PERCENT) {
                $query->update([
                    'discount_price' => DB::raw("price * (100 - {$promotion->action_amount}) / 100")
                ]);
            } else {
                $query->update([
                    'discount_price' => $promotion->action_amount
                ]);
            }
        }
    }
}

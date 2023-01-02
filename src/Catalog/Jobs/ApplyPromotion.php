<?php

namespace Modules\Catalog\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;
use Modules\Catalog\Entities\Promotion;
use Modules\Catalog\Repositories\PromotionRepository;
use Modules\Catalog\Repositories\VariantRepository;
use Modules\Catalog\Services\PromotionService;

class ApplyPromotion implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $promotion;

    public function __construct(Promotion $promotion)
    {
        $this->promotion = $promotion;
    }

    public function handle(
        PromotionRepository $promotionRepository,
        VariantRepository $variantRepository,
        PromotionService $promotionService
    ) {
        DB::transaction(function () use ($promotionRepository, $variantRepository, $promotionService) {
            $promotions = $promotionRepository->getAllActivated();
            $variantRepository->resetAllDiscountPrice();

            foreach ($promotions as $promotion) {
                $promotionService->apply($promotion);
            }
        });
    }
}

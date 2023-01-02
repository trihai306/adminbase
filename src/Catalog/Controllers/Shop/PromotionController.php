<?php

namespace Modules\Catalog\Controllers\Shop;

use Modules\Catalog\Jobs\ApplyPromotion;
use Modules\Catalog\Repositories\PromotionRepository;
use Modules\Catalog\Requests\Admin\IndexPromotionRequest;
use Modules\Catalog\Requests\Admin\StorePromotionRequest;
use Modules\Catalog\Requests\Admin\UpdatePromotionRequest;
use Modules\Catalog\Transformers\PromotionCollection;
use Modules\Catalog\Transformers\PromotionResource;
use Modules\Core\Controllers\Controller;

class PromotionController extends Controller
{
    private $promotionRepository;

    public function __construct(PromotionRepository $promotionRepository)
    {
        $this->promotionRepository = $promotionRepository;
    }

    public function index(IndexPromotionRequest $request)
    {
        $promotions = $this->promotionRepository->query(
            $request->validated()
        );

        return new PromotionCollection($promotions);
    }

    public function show($id)
    {
        if (is_numeric($id)) {
            $promotion = $this->promotionRepository->find($id) ?? $this->promotionRepository->findByCode($id);
        } else {
            $promotion = $this->promotionRepository->findByCode($id);
        }

        $promotion = $this->promotionRepository->query([
            'id' => $promotion->id
        ]);

        return new PromotionResource($promotion);
    }
}

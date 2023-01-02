<?php

namespace Modules\Catalog\Controllers\Admin;

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

    public function store(StorePromotionRequest $request)
    {
        $promotion = $this->promotionRepository->create(
            $request->validated()
        );

        $promotion = $this->promotionRepository->query([
            'id' => $promotion->id
        ]);

        ApplyPromotion::dispatch($promotion)->delay($promotion->start_at);

        return new PromotionResource($promotion);
    }

    public function show($id)
    {
        $promotion = $this->promotionRepository->find($id) ?? $this->promotionRepository->findByCode($id);

        $promotion = $this->promotionRepository->query([
            'id' => $promotion->id
        ]);

        return new PromotionResource($promotion);
    }

    public function update($id, UpdatePromotionRequest $request)
    {
        $promotion = $this->promotionRepository->find($id);

        $promotion = $this->promotionRepository->update(
            $request->validated(),
            $promotion->id
        );

        ApplyPromotion::dispatch($promotion)->delay($promotion->start_at);

        $promotion = $this->promotionRepository->query([
            'id' => $promotion->id
        ]);

        return new PromotionResource($promotion);
    }

    public function destroy($id)
    {
        $promotion = $this->promotionRepository->find($id);

        $this->promotionRepository->delete($promotion->id);

        ApplyPromotion::dispatchAfterResponse($promotion);

        return $this->respondSuccess('Xóa chương trình khuyến mãi thành công.');
    }
}

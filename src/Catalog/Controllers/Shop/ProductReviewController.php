<?php

namespace Modules\Catalog\Controllers\Shop;

use Modules\Catalog\Repositories\ReviewRepository;
use Modules\Catalog\Requests\Shop\IndexReviewRequest;
use Modules\Catalog\Requests\Shop\StoreReviewRequest;
use Modules\Catalog\Transformers\ReviewCollection;
use Modules\Catalog\Transformers\ReviewResource;
use Modules\Core\Controllers\Controller;
use Modules\User\Services\AuthenticationService;

class ProductReviewController extends Controller
{
    private $authenticationService;
    private $reviewRepository;

    public function __construct(
        AuthenticationService $authenticationService,
        ReviewRepository $reviewRepository
    ) {
        $this->authenticationService = $authenticationService;
        $this->reviewRepository = $reviewRepository;
    }

    public function index($productId, IndexReviewRequest $request)
    {
        $reviews = $this->reviewRepository->query(
            array_merge($request->validated(), [
                'product_id' => $productId,
                'parent_id' => null
            ])
        );

        $ratingsCount = $this->reviewRepository->getRatingsCount($productId);
        $ratingsAvg = $this->reviewRepository->getRatingsAvg($productId);

        return (new ReviewCollection($reviews))->additional([
            'meta' => [
                'ratings_count' => (int) $ratingsCount,
                'ratings_avg' => (float) $ratingsAvg
            ]
        ]);
    }
}

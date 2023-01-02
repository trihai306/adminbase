<?php

namespace Modules\Catalog\Controllers\Shop;

use Modules\Catalog\Repositories\ReviewRepository;
use Modules\Catalog\Requests\Shop\IndexReviewRequest;
use Modules\Catalog\Requests\Shop\StoreReviewRequest;
use Modules\Catalog\Transformers\ReviewCollection;
use Modules\Catalog\Transformers\ReviewResource;
use Modules\Core\Controllers\Controller;
use Modules\User\Services\AuthenticationService;

class ReviewController extends Controller
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

    public function index(IndexReviewRequest $request)
    {
        $reviews = $this->reviewRepository->query(
            $request->validated()
        );

        return new ReviewCollection($reviews);
    }

    public function store(StoreReviewRequest $request)
    {
        $user = $this->authenticationService->currentUser();

        $review = $this->reviewRepository->create(
            array_merge($request->validated(), [
                'reviewer_id' => $user->id
            ])
        );

        $review = $this->reviewRepository->query([
            'id' => $review->id
        ]);

        return new ReviewResource($review);
    }
}

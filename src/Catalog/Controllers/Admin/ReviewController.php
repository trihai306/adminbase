<?php

namespace Modules\Catalog\Controllers\Admin;

use Modules\Catalog\Repositories\ReviewRepository;
use Modules\Catalog\Requests\Shop\IndexReviewRequest;
use Modules\Catalog\Transformers\ReviewCollection;
use Modules\Core\Controllers\Controller;

class ReviewController extends Controller
{
    private $reviewRepository;

    public function __construct(ReviewRepository $reviewRepository)
    {
        $this->reviewRepository = $reviewRepository;
    }

    public function index(IndexReviewRequest $request)
    {
        $reviews = $this->reviewRepository->query(
            $request->validated()
        );

        return new ReviewCollection($reviews);
    }

    public function destroy($id)
    {
        $this->reviewRepository->delete($id);

        return $this->respondSuccess('Xóa đánh giá thành công.');
    }
}

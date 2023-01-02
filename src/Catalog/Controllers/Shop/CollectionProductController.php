<?php

namespace Modules\Catalog\Controllers\Shop;

use Modules\Catalog\Repositories\CollectionRepository;
use Modules\Catalog\Repositories\ProductRepository;
use Modules\Catalog\Requests\Shop\IndexProductRequest;
use Modules\Catalog\Transformers\ProductCollection;
use Modules\Core\Controllers\Controller;

class CollectionProductController extends Controller
{
    private $collectionRepository;
    private $productRepository;

    public function __construct(
        CollectionRepository $collectionRepository,
        ProductRepository $productRepository
    )
    {
        $this->collectionRepository = $collectionRepository;
        $this->productRepository = $productRepository;
    }

    public function index($collectionId, IndexProductRequest $request)
    {
        if (is_numeric($collectionId)) {
            $collection = $this->collectionRepository->find($collectionId) ??
                $this->collectionRepository->findByCode($collectionId);
        } else {
            $collection = $this->collectionRepository->findByCode($collectionId);
        }

        $products = $this->productRepository->query(
            array_merge($request->validated(), [
                'collection_id' => $collection->id
            ])
        );

        return new ProductCollection($products);
    }

    public function indexNewest()
    {
        $products = $this->productRepository->queryNewest([]);

        return new ProductCollection($products);
    }

    public function indexRecommendation()
    {
        $products = $this->productRepository->queryRecommendation([]);

        return new ProductCollection($products);
    }

    public function indexBestselling() {
        $products = $this->productRepository->queryBestselling([]);

        return new ProductCollection($products);
    }

    public function indexUnder100k() {
        $products = $this->productRepository->queryUnder100k([]);

        return new ProductCollection($products);
    }

    public function indexHighReview() {
        $products = $this->productRepository->queryHighReview([]);

        return new ProductCollection($products);
    }
}

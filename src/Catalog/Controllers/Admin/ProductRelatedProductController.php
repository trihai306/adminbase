<?php

namespace Modules\Catalog\Controllers\Admin;

use Modules\Catalog\Repositories\ProductRepository;
use Modules\Catalog\Requests\Admin\IndexProductRequest;
use Modules\Catalog\Services\ProductService;
use Modules\Catalog\Transformers\ProductCollection;
use Modules\Core\Controllers\Controller;

class ProductRelatedProductController extends Controller
{
    private $productRepository;
    private $productService;

    public function __construct(
        ProductRepository $productRepository,
        ProductService $productService
    ) {
        $this->productRepository = $productRepository;
        $this->productService = $productService;
    }

    public function index($productId, IndexProductRequest $request)
    {
        $product = $this->productRepository->find($productId);

        $products = $this->productRepository->query(
            array_merge($request->validated(), [
                'related_product_id' => $product->id
            ])
        );

        return new ProductCollection($products);
    }
}

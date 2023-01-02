<?php

namespace Modules\Catalog\Controllers\Shop;

use Illuminate\Support\Facades\Storage;
use Modules\Catalog\Repositories\ProductRepository;
use Modules\Catalog\Requests\Shop\IndexProductRequest;
use Modules\Catalog\Transformers\ProductCollection;
use Modules\Catalog\Transformers\ProductResource;
use Modules\Core\Controllers\Controller;

class ProductController extends Controller
{
    private $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function index(IndexProductRequest $request)
    {
        $products = $this->productRepository->query(
            $request->validated()
        );

        return new ProductCollection($products);
    }

    public function show($id)
    {
        $product = $this->productRepository->query([
            'id' => $id
        ]);

        return new ProductResource($product);
    }

    public function showContent($id)
    {
        try {
            $content = Storage::get("content/$id");
        } catch (\Exception $exception) {
            $content = '';
        }
        return response()->json([
            'data' => $content
        ]);
    }
}

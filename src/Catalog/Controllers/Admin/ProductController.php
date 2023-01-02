<?php

namespace Modules\Catalog\Controllers\Admin;

use Illuminate\Support\Facades\Storage;
use Modules\Catalog\Repositories\ProductRepository;
use Modules\Catalog\Requests\Admin\IndexProductRequest;
use Modules\Catalog\Requests\Admin\StoreProductRequest;
use Modules\Catalog\Requests\Admin\UpdateProductRequest;
use Modules\Catalog\Services\ProductService;
use Modules\Catalog\Transformers\ProductCollection;
use Modules\Catalog\Transformers\ProductResource;
use Modules\Core\Controllers\Controller;

class ProductController extends Controller
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

    public function index(IndexProductRequest $request)
    {
        $products = $this->productRepository->query(
            $request->validated()
        );

        return new ProductCollection($products);
    }

    public function store(StoreProductRequest $request)
    {
        $product = $this->productService->create(
            $request->validated()
        );

        $product = $this->productRepository->query([
            'id' => $product->id
        ]);

        return new ProductResource($product);
    }

    public function show($id)
    {
        $product = $this->productRepository->query([
            'id' => $id
        ]);

        return new ProductResource($product);
    }

    public function update($id, UpdateProductRequest $request)
    {
        $product = $this->productRepository->find($id);

        $this->productService->update(
            $request->validated(),
            $product->id
        );

        $product = $this->productRepository->query([
            'id' => $product->id
        ]);

        return new ProductResource($product);
    }

    public function destroy($id)
    {
        $product = $this->productRepository->find($id);

        $this->productRepository->delete($product->id);

        return $this->respondSuccess('Xóa sản phẩm thành công.');
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

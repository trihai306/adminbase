<?php

namespace Modules\Catalog\Controllers\Shop;

use Modules\Catalog\Repositories\CategoryRepository;
use Modules\Catalog\Requests\Shop\IndexCategoryRequest;
use Modules\Catalog\Transformers\CategoryCollection;
use Modules\Catalog\Transformers\CategoryResource;
use Modules\Core\Controllers\Controller;

class CategoryController extends Controller
{
    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function index(IndexCategoryRequest $request)
    {
        $categories = $this->categoryRepository->query(
            $request->validated()
        );

        return new CategoryCollection($categories);
    }

    public function show($id)
    {
        if (is_numeric($id)) {
            $category = $this->categoryRepository->find($id) ?? $this->categoryRepository->findByCode($id);
        } else {
            $category = $this->categoryRepository->findByCode($id);
        }

        $category = $this->categoryRepository->query([
            'id' => $category->id
        ]);

        return new CategoryResource($category);
    }
}

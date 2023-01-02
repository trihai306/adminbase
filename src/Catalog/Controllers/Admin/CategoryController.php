<?php

namespace Modules\Catalog\Controllers\Admin;

use Modules\Catalog\Repositories\CategoryRepository;
use Modules\Catalog\Requests\Admin\IndexCategoryRequest;
use Modules\Catalog\Requests\Admin\StoreCategoryRequest;
use Modules\Catalog\Requests\Admin\UpdateCategoryRequest;
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

    public function store(StoreCategoryRequest $request)
    {
        $category = $this->categoryRepository->create(
            $request->validated()
        );

        $category = $this->categoryRepository->query([
            'id' => $category->id
        ]);

        return new CategoryResource($category);
    }

    public function show($id)
    {
        $category = $this->categoryRepository->find($id) ?? $this->categoryRepository->findByCode($id);

        $category = $this->categoryRepository->query([
            'id' => $category->id
        ]);

        return new CategoryResource($category);
    }

    public function update($id, UpdateCategoryRequest $request)
    {
        $category = $this->categoryRepository->find($id);

        $this->categoryRepository->update(
            $request->validated(),
            $category->id
        );

        $category = $this->categoryRepository->query([
            'id' => $category->id
        ]);

        return new CategoryResource($category);
    }

    public function destroy($id)
    {
        $category = $this->categoryRepository->find($id);

        $this->categoryRepository->delete($category->id);

        return $this->respondSuccess('Xóa danh mục thành công.');
    }
}

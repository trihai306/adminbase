<?php

namespace Modules\Catalog\Controllers\Admin;

use Modules\Catalog\Repositories\CategoryRepository;
use Modules\Catalog\Repositories\CategoryTagRepository;
use Modules\Catalog\Requests\Admin\IndexCategoryRequest;
use Modules\Catalog\Requests\Admin\IndexCategoryTagRequest;
use Modules\Catalog\Requests\Admin\StoreCategoryRequest;
use Modules\Catalog\Requests\Admin\StoreCategoryTagRequest;
use Modules\Catalog\Requests\Admin\UpdateCategoryRequest;
use Modules\Catalog\Transformers\CategoryCollection;
use Modules\Catalog\Transformers\CategoryResource;
use Modules\Catalog\Transformers\CategoryTagCollection;
use Modules\Catalog\Transformers\CategoryTagResource;
use Modules\Core\Controllers\Controller;

class CategoryTagController extends Controller
{
    private $categoryTagRepository;

    public function __construct(CategoryTagRepository $categoryTagRepository)
    {
        $this->categoryTagRepository = $categoryTagRepository;
    }

    public function index(IndexCategoryTagRequest $request)
    {
        $categoryTags = $this->categoryTagRepository->query(
            $request->validated()
        );

        return new CategoryTagCollection($categoryTags);
    }

    public function store(StoreCategoryTagRequest $request)
    {
        $categoryTag = $this->categoryTagRepository->create(
            $request->validated()
        );

        $categoryTag = $this->categoryTagRepository->query([
            'id' => $categoryTag->id
        ]);

        return new CategoryTagResource($categoryTag);
    }

    public function destroy($id)
    {
        $this->categoryTagRepository->delete($id);

        return $this->respondSuccess('Xóa nhãn danh mục thành công.');
    }
}

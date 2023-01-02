<?php

namespace Modules\Catalog\Controllers\Shop;

use Modules\Catalog\Repositories\CategoryRepository;
use Modules\Catalog\Repositories\CategoryTagRepository;
use Modules\Catalog\Requests\Shop\IndexCategoryRequest;
use Modules\Catalog\Transformers\CategoryCollection;
use Modules\Catalog\Transformers\CategoryResource;
use Modules\Catalog\Transformers\CategoryTagCollection;
use Modules\Core\Controllers\Controller;

class CategoryChildrenTagController extends Controller
{
    private $categoryTagRepository;

    public function __construct(CategoryTagRepository $categoryTagRepository)
    {
        $this->categoryTagRepository = $categoryTagRepository;
    }

    public function index($categoryId, IndexCategoryRequest $request)
    {
        $categoryTags = $this->categoryTagRepository->query(
            array_merge($request->validated(), [
                'parent_category_id' => $categoryId
            ])
        );

        return new CategoryTagCollection($categoryTags);
    }
}

<?php

namespace Modules\Catalog\Controllers\Shop;

use Modules\Catalog\Repositories\CategoryRepository;
use Modules\Catalog\Transformers\CategoryTreeCollection;
use Modules\Core\Controllers\Controller;

class CategoryTreeController extends Controller
{
    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function index()
    {
        $categoryTrees = $this->categoryRepository->getTrees();

        return new CategoryTreeCollection($categoryTrees);
    }
}

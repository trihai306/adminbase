<?php

namespace Modules\Catalog\Console;

use Illuminate\Support\Facades\DB;
use Modules\Catalog\Repositories\CategoryRepository;
use phpDocumentor\Reflection\Types\Null_;

class MigrateCategoryCommand extends MigrateCommand
{
    protected $name = 'migrate:category';

    protected $description = 'Migrate product from old database.';

    public function handle(CategoryRepository $categoryRepository)
    {
        $this->setupOldDatabaseConnection();

        $oldCategories = DB::connection('old_mysql')->table('catalogs')
            ->get();

        $groupedOldCategories = $oldCategories->groupBy('catalog_id');

        $rootOldCategories = $groupedOldCategories->get(null, []);
        foreach ($rootOldCategories as $oldCategory) {
            $this->createCategory($categoryRepository, $groupedOldCategories, $oldCategory);
        }
    }

    protected function createCategory($categoryRepository, $groupedOldCategories, $oldCategory, $parentId = null) {
        $category = $categoryRepository->create([
            'parent_id' => $parentId,
            'code' => $oldCategory->slug,
            'name' => $oldCategory->name,
            'slug' => $oldCategory->slug,
            'image' => $oldCategory->image ? $this->storeMediaImage($oldCategory->image) : null
        ]);

        $oldCategoryChildren = $groupedOldCategories->get($oldCategory->id, []);
        foreach ($oldCategoryChildren as $childOldCategory) {
            $this->createCategory($categoryRepository, $groupedOldCategories, $childOldCategory, $category->id);
        }
    }
}

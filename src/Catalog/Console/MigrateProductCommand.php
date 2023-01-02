<?php

namespace Modules\Catalog\Console;

use Illuminate\Support\Facades\DB;
use Modules\Catalog\Entities\Category;
use Modules\Catalog\Entities\Option;
use Modules\Catalog\Entities\OptionValue;
use Modules\Catalog\Enums\OrderType;
use Modules\Catalog\Enums\ProductStatus;
use Modules\Catalog\Enums\StockStatus;
use Modules\Catalog\Services\ProductService;

class MigrateProductCommand extends MigrateCommand
{
    protected $name = 'migrate:product';

    protected $description = 'Migrate product from old database.';

    public function handle(ProductService $productService)
    {
        $this->setupOldDatabaseConnection();

        $options = Option::all();
        $optionValues = OptionValue::all();

        $oldProducts = DB::connection('old_mysql')->table('products')
            ->leftJoin('areas', 'areas.id', 'products.area_id')
            ->leftJoin('brands', 'brands.id', 'products.brand_id')
            ->leftJoin('platforms', 'platforms.id', 'products.platform_id')
            ->leftJoin('product_types', 'product_types.id', 'products.product_type_id')
            ->whereNull('products.deleted_at')
            ->selectRaw('products.*, areas.name as area_code, brands.name as platform_code, platforms.name as system_code, product_types.name as product_type_code')
            ->get();

        foreach ($oldProducts as $oldProduct) {
            $this->createProduct($productService, $options, $optionValues, $oldProduct);
        }
    }

    protected function createProduct($productService, $options, $optionValues, $oldProduct)
    {
        $optionIds = $options->pluck('id');
        $optionValueIds = $optionValues->whereIn('code', [
                $oldProduct->area_code,
                $oldProduct->platform_code,
                $oldProduct->system_code,
                $oldProduct->product_type_code
            ])
            ->pluck('id');

        $imagePath = $this->storeMediaImage($oldProduct->image_square);

        $categoryCodes = DB::connection('old_mysql')->table('catalogs')
            ->join('catalog_product', 'catalog_product.catalog_id', 'catalogs.id')
            ->where('catalog_product.product_id', $oldProduct->id)
            ->pluck('catalogs.slug');

        $categoryIds = Category::whereIn('code', $categoryCodes->toArray())
            ->pluck('id');

        $productService->create([
            'name' => $oldProduct->name,
            'slug' => $oldProduct->slug,
            'image' => $imagePath,
            'initial_sold_count' => $oldProduct->quantity_sold,
            'important_message' => $oldProduct->important_notification,
            'option_ids' => $optionIds->toArray(),
            'category_id' => $categoryIds->first(),
            'category_ids' => $categoryIds->toArray(),
            'content' => $oldProduct->description,
            'variants' => [
                [
                    'name' => $oldProduct->name,
                    'image' => $imagePath,
                    'price' => $oldProduct->regular_price,
                    'discount_price' => null,
                    'order_type' => $oldProduct->type === 'auto' ? OrderType::IMMEDIATE : OrderType::ORDER,
                    'stock_status' => StockStatus::IN_STOCK,
                    'is_default' => true,
                    'option_value_ids' => $optionValueIds->toArray(),
                ]
            ],
            'status' => ProductStatus::PUBLISHED
        ]);
    }
}

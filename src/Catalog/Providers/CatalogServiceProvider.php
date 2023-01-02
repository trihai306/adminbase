<?php

namespace Modules\Catalog\Providers;

use Illuminate\Database\Eloquent\Factory;
use Modules\Catalog\Repositories\AttributeRepository;
use Modules\Catalog\Repositories\BrandRepository;
use Modules\Catalog\Repositories\CategoryRepository;
use Modules\Catalog\Repositories\CategoryTagRepository;
use Modules\Catalog\Repositories\CollectionRepository;
use Modules\Catalog\Repositories\EloquentAttributeRepository;
use Modules\Catalog\Repositories\EloquentBrandRepository;
use Modules\Catalog\Repositories\EloquentCategoryRepository;
use Modules\Catalog\Repositories\EloquentCategoryTagRepository;
use Modules\Catalog\Repositories\EloquentCollectionRepository;
use Modules\Catalog\Repositories\EloquentHistoryPointRepository;
use Modules\Catalog\Repositories\EloquentOptionRepository;
use Modules\Catalog\Repositories\EloquentProductRepository;
use Modules\Catalog\Repositories\EloquentPromotionRepository;
use Modules\Catalog\Repositories\EloquentReviewRepository;
use Modules\Catalog\Repositories\EloquentUserVoucherRepository;
use Modules\Catalog\Repositories\EloquentVariantRepository;
use Modules\Catalog\Repositories\EloquentVoucherRepository;
use Modules\Catalog\Repositories\HistoryPointRepository;
use Modules\Catalog\Repositories\OptionRepository;
use Modules\Catalog\Repositories\ProductRepository;
use Modules\Catalog\Repositories\PromotionRepository;
use Modules\Catalog\Repositories\ReviewRepository;
use Modules\Catalog\Repositories\UserVoucherRepository;
use Modules\Catalog\Repositories\VariantRepository;
use Modules\Catalog\Repositories\VoucherRepository;
use Modules\Core\Providers\ModuleServiceProvider;

class CatalogServiceProvider extends ModuleServiceProvider
{
    protected $moduleName = 'Catalog';

    protected $moduleNameLower = 'catalog';

    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
        $this->app->register(CommandServiceProvider::class);
        $this->app->bind(CategoryRepository::class, EloquentCategoryRepository::class);
        $this->app->bind(CollectionRepository::class, EloquentCollectionRepository::class);
        $this->app->bind(ProductRepository::class, EloquentProductRepository::class);
        $this->app->bind(AttributeRepository::class, EloquentAttributeRepository::class);
        $this->app->bind(OptionRepository::class, EloquentOptionRepository::class);
        $this->app->bind(VariantRepository::class, EloquentVariantRepository::class);
        $this->app->bind(ReviewRepository::class, EloquentReviewRepository::class);
        $this->app->bind(PromotionRepository::class, EloquentPromotionRepository::class);
        $this->app->bind(BrandRepository::class, EloquentBrandRepository::class);
        $this->app->bind(CategoryTagRepository::class, EloquentCategoryTagRepository::class);
        $this->app->bind(VoucherRepository::class, EloquentVoucherRepository::class);
        $this->app->bind(HistoryPointRepository::class, EloquentHistoryPointRepository::class);
        $this->app->bind(UserVoucherRepository::class, EloquentUserVoucherRepository::class);
    }
}

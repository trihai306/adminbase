<?php

namespace Modules\Catalog\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Modules\Catalog\Entities\Product;
use Modules\Catalog\Repositories\Filters\PriceRangeFilter;
use Modules\Catalog\Repositories\Sorts\PriceSort;
use Modules\Core\Repositories\EloquentRepository;
use Modules\Core\Repositories\Filters\RelationColumnFilter;
use Modules\Core\Repositories\Includes\AggregateInclude;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedInclude;
use Spatie\QueryBuilder\AllowedSort;

class EloquentProductRepository extends EloquentRepository implements ProductRepository
{
    protected $allowedSearch = true;

    protected $allowedFilters = [
        'id',
        'category_id',
        'code',
        'name',
        'status'
    ];

    protected $allowedSorts = [
        'id',
        'code',
        'name',
        'updated_at',
        'created_at'
    ];

    protected $allowedIncludes = [
        'category',
        'category.ancestors',
        'category.descendants',
        'attributes',
        'attribute_ids',
        'options',
        'option_ids',
        'categories',
        'category_ids',
        'categories.ancestors',
        'categories.descendants',
        'collections',
        'collection_ids',
        'variants',
        'variants.option_values',
        'default_variant',
        'default_variant.option_values',
        'default_variant.option_value_ids',
        'related_products',
        'related_product_ids',
        'reviews',
        'ratings'
    ];

    public function __construct(Product $model)
    {
        parent::__construct($model);
    }

    public function query(array $conditions)
    {
        $query = $this->model->newQuery();

        if (isset($conditions['related_product_id'])) {
            $query = $query->join('related_product', 'related_product.related_product_id', 'products.id')
                ->where('related_product.product_id', $conditions['related_product_id']);
        }

        if (isset($conditions['collection_id'])) {
            $query = $query->whereHas('collections', function ($query) use ($conditions) {
                return $query->where('id', $conditions['collection_id']);
            });
        }

        return $this->executeQuery($conditions, $query);
    }

    public function create(array $attributes): Model
    {
        return DB::transaction(function () use ($attributes) {
            $product = parent::create($attributes);

            if (isset($attributes['slug'])) {
                $product->slug()->create([
                    'prefix' => 'products',
                    'slug' => $attributes['slug'],
                    'keywords' => $attributes['meta_keywords'] ?? null,
                    'description' => $attributes['meta_description'] ?? null
                ]);
            }

            if (isset($attributes['category_ids'])) {
                $product->categories()->attach($attributes['category_ids']);
            }

            if (isset($attributes['collection_ids'])) {
                $product->collections()->attach($attributes['collection_ids']);
            }

            if (isset($attributes['option_ids'])) {
                $product->options()->attach($attributes['option_ids']);
            }

            if (isset($attributes['attribute_ids'])) {
                $product->attributes()->attach($attributes['attribute_ids']);
            }

            if (isset($attributes['related_product_ids'])) {
                $product->relatedProducts()->attach($attributes['related_product_ids']);
            }

            if (isset($attributes['content'])) {
                Storage::put("content/$product->id", $attributes['content']);
            }

            return $product;
        });
    }

    public function update(array $attributes, $id): Model
    {
        return DB::transaction(function () use ($attributes, $id) {
            $product = parent::update($attributes, $id);

            if (isset($attributes['slug'])) {
                $product->slug->update([
                    'slug' => $attributes['slug'],
                    'keywords' => $attributes['meta_keywords'] ?? null,
                    'description' => $attributes['meta_description'] ?? null
                ]);
            }

            if (isset($attributes['category_ids'])) {
                $product->categories()->sync($attributes['category_ids']);
            }

            if (isset($attributes['collection_ids'])) {
                $product->collections()->sync($attributes['collection_ids']);
            }

            if (isset($attributes['option_ids'])) {
                $product->options()->sync($attributes['option_ids']);
            }

            if (isset($attributes['attribute_ids'])) {
                $product->attributes()->sync($attributes['attribute_ids']);
            }

            if (isset($attributes['related_product_ids'])) {
                $product->relatedProducts()->sync($attributes['related_product_ids']);
            }

            if (isset($attributes['content'])) {
                Storage::put("content/$product->id", $attributes['content']);
            }

            return $product;
        });
    }

    public function queryNewest(array $conditions)
    {
        $query = $this->newQueryBuilder()
            ->orderBy('updated_at', 'desc');

        return $query->getOrPaginate();
    }

    public function queryRecommendation(array $conditions)
    {
        $query = $this->newQueryBuilder()
            ->orderBy('updated_at', 'desc');

        return $query->getOrPaginate();
    }

    public function queryBestselling(array $conditions)
    {
        $query = $this->newQueryBuilder()
            ->orderBy('initial_sold_count', 'desc');

        return $query->getOrPaginate();
    }

    public function queryUnder100k(array $conditions)
    {
        $query = $this->newQueryBuilder()
            ->join('variants', function ($join) {
                $join->on('products.id', '=', 'variants.product_id')
                    ->where('price', '<', 100000)
                    ->where('variants.is_default', true);
            });

        return $query->getOrPaginate();
    }

    public function queryHighReview(array $conditions)
    {
        $query = $this->newQueryBuilder()
            ->withCount('ratings')
            ->orderBy('ratings_count', 'desc');

        return $query->getOrPaginate();
    }

    protected function allowedFilters(): array
    {
        return array_merge(parent::allowedFilters(), [
            AllowedFilter::custom(
                'main_category_id',
                new RelationColumnFilter('category', ['id', 'code'])
            ),
            AllowedFilter::custom(
                'category_id',
                new RelationColumnFilter('categories', ['id', 'code'])
            ),
            AllowedFilter::custom(
                'collection_id',
                new RelationColumnFilter('collections', ['id', 'code'])
            ),
            AllowedFilter::custom(
                'related_product_id',
                new RelationColumnFilter('relatedProducts', 'product_id')
            ),
            AllowedFilter::custom(
                'promotion_id',
                new RelationColumnFilter('promotions', ['id', 'code'])
            ),
            AllowedFilter::custom(
                'option_value_id',
                new RelationColumnFilter('defaultVariant.optionValues', ['id', 'code'])
            ),
            AllowedFilter::custom(
                'price_range',
                new PriceRangeFilter()
            )
        ]);
    }

    protected function allowedSorts(): array
    {
        return array_merge(parent::allowedSorts(), [
            AllowedSort::custom('price', new PriceSort()),
            AllowedSort::field('popular', 'initial_sold_count'),
            AllowedSort::field('sold_count', 'initial_sold_count')
        ]);
    }


    protected function  allowedIncludes(): array
    {
        return array_merge(parent::allowedIncludes(), [
            AllowedInclude::custom('ratings_avg', new AggregateInclude('rating', 'avg'), 'ratings')
        ]);
    }
}

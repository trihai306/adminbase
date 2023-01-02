<?php

namespace Modules\Catalog\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Catalog\Entities\Variant;
use Modules\Core\Repositories\EloquentRepository;

class EloquentVariantRepository extends EloquentRepository implements VariantRepository
{
    protected $allowedSearch = true;

    protected $allowedFilters = [
        'id',
        'code',
        'name',
        'product_id',
        'order_type'
    ];

    protected $allowedSorts = [
        'id',
        'code',
        'name',
        'price',
        'sale_price',
        'discount_price',
        'currency',
        'updated_at',
        'created_at'
    ];

    protected $allowedIncludes = [
        'option_values',
        'option_value_ids'
    ];

    public function __construct(Variant $model)
    {
        parent::__construct($model);
    }

    public function create(array $attributes): Model
    {
        return DB::transaction(function () use ($attributes) {
            $variant = parent::create($attributes);

            if (isset($attributes['option_value_ids'])) {
                $variant->optionValues()->attach($attributes['option_value_ids']);
            }

            if (isset($attributes['attribute_values'])) {
                $variant->attributes()->attach(
                    collect($attributes['attribute_values'])->mapWithKeys(function ($value) {
                        return [$value['attribute_id'] => $value];
                    })
                );
            }

            return $variant;
        });
    }

    public function update(array $attributes, $id): Model
    {
        return DB::transaction(function () use ($attributes, $id) {
            $variant = parent::update($attributes, $id);

            if (isset($attributes['option_value_ids'])) {
                $variant->optionValues()->sync($attributes['option_value_ids']);
            }

            if (isset($attributes['attribute_values'])) {
                $variant->attributes()->sync(
                    collect($attributes['attribute_values'])->mapWithKeys(function ($value) {
                        return [$value['attribute_id'] => $value];
                    })
                );
            }

            return $variant;
        });
    }

    public function deleteNotIn(array $ids)
    {
        return $this->model->newQuery()
            ->whereNotIn('id', $ids)
            ->delete();
    }

    public function resetAllDiscountPrice()
    {
        return $this->model->newQuery()
            ->update(['discount_price' => null]);
    }
}

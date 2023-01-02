<?php

namespace Modules\Catalog\Repositories;

use Illuminate\Support\Facades\DB;
use Modules\Catalog\Entities\Promotion;
use Modules\Catalog\Enums\PromotionStatus;
use Modules\Core\Repositories\EloquentRepository;

class EloquentPromotionRepository extends EloquentRepository implements PromotionRepository
{
    protected $allowedSearch = true;

    protected $allowedFilters = [
        'id',
        'code',
        'name'
    ];

    protected $allowedSorts = [
        'id',
        'code',
        'name',
        'updated_at',
        'created_at'
    ];

    protected $allowedIncludes = [
        'products',
        'product_ids'
    ];

    public function __construct(Promotion $model)
    {
        parent::__construct($model);
    }

    public function create(array $attributes)
    {
        return DB::transaction(function () use ($attributes) {
            $promotion = parent::create($attributes);

            if (isset($attributes['product_ids'])) {
                $promotion->products()->attach(
                    collect($attributes['product_ids'])->unique()->toArray()
                );
            }

            return $promotion;
        });
    }

    public function update(array $attributes, $id)
    {
        return DB::transaction(function () use ($attributes, $id) {
            $promotion = parent::update($attributes, $id);

            if (isset($attributes['product_ids'])) {
                $promotion->products()->sync($attributes['product_ids']);
            }

            return $promotion;
        });
    }

    public function findByCode($code)
    {
        return $this->model->newQuery()
            ->where('code', $code)
            ->first();
    }

    public function getAllActivated()
    {
        return $this->newQuery()
            ->where('status', PromotionStatus::ACTIVATED)
            ->inAvailableTime(now())
            ->get();
    }
}

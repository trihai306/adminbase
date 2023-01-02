<?php

namespace Modules\Catalog\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Catalog\Entities\Option;
use Modules\Core\Repositories\EloquentRepository;

class EloquentOptionRepository extends EloquentRepository implements OptionRepository
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
        'values'
    ];

    public function __construct(Option $model)
    {
        parent::__construct($model);
    }

    public function create(array $attributes): Model
    {
        return DB::transaction(function () use ($attributes) {
            $option = parent::create($attributes);

            if (isset($attributes['values'])) {
                $option->values()->createMany($attributes['values']);
            }

            return $option;
        });
    }

    public function update(array $attributes, $id): Model
    {
        return DB::transaction(function () use ($attributes, $id) {
            $option = parent::update($attributes, $id);

            if (isset($attributes['values'])) {
                $newValues = [];
                $existedValues = [];
                $existedValueIds = [];

                foreach ($attributes['values'] as $value) {
                    if (empty($value['id'])) {
                        $newValues[] = $value;
                    } else {
                        $existedValues[] = $value;
                        $existedValueIds[] = $value['id'];
                    }
                }

                $option->values()
                    ->whereNotIn('id', $existedValueIds)
                    ->delete();

                $option->values()->createMany($newValues);

                foreach ($existedValues as $value) {
                    $option->values()->where('id', $value['id'])
                        ->update($value);
                }
            }

            return $option;
        });
    }

    public function delete($id): bool
    {
        return DB::transaction(function () use ($id) {
            $option = $this->find($id);

            $option->values()->delete();
            $option->delete();

            return true;
        });
    }
}

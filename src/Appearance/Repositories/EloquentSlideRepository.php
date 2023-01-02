<?php

namespace Modules\Appearance\Repositories;

use Illuminate\Support\Facades\DB;
use Modules\Appearance\Entities\Slide;
use Modules\Core\Repositories\EloquentRepository;

class EloquentSlideRepository extends EloquentRepository implements SlideRepository
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
        'items'
    ];

    public function __construct(Slide $model)
    {
        parent::__construct($model);
    }

    public function findByCode($code)
    {
        return $this->model->newQuery()
            ->where('code', $code)
            ->first();
    }

    public function create(array $attributes)
    {
        return DB::transaction(function () use ($attributes) {
            $slide = parent::create($attributes);

            if (isset($attributes['items'])) {
                $slide->items()->createMany(
                    $this->assignIndex($attributes['items'])
                );
            }

            return $slide;
        });
    }

    public function update(array $attributes, $id)
    {
        return DB::transaction(function () use ($attributes, $id) {
            $slide = parent::update($attributes, $id);

            if (isset($attributes['items'])) {
                $newItems = [];
                $existedItems = [];
                $existedItemIds = [];
                foreach ($this->assignIndex($attributes['items']) as $item) {
                    if (isset($item['id'])) {
                        $existedItems[] = $item;
                        $existedItemIds[] = $item['id'];
                    } else {
                        $newItems[] = $item;
                    }
                }

                $slide->items()->whereNotIn('id', $existedItemIds)
                    ->delete();

                $slide->items()->createMany($newItems);

                foreach ($existedItems as $item) {
                    $slide->items()->where('id', $item['id'])
                        ->update($item);
                }
            }

            return $slide;
        });
    }

    public function delete($id): bool
    {
        return DB::transaction(function () use ($id) {
            $slide = $this->find($id);

            $slide->items()->delete();
            $slide->delete();

            return true;
        });
    }

    protected function assignIndex($items)
    {
        $index = 0;
        return array_map(function ($item) use (&$index) {
            $item['index'] = $index++;

            return $item;
        }, $items);
    }
}

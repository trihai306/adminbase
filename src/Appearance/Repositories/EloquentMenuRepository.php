<?php

namespace Modules\Appearance\Repositories;

use Illuminate\Support\Facades\DB;
use Modules\Appearance\Entities\Menu;
use Modules\Appearance\Entities\MenuItem;
use Modules\Core\Repositories\EloquentRepository;

class EloquentMenuRepository extends EloquentRepository implements MenuRepository
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

    public function __construct(Menu $model)
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
            $menu = parent::create($attributes);

            if (isset($attributes['items'])) {
                $items = $this->assignMenuIdAndIndex($menu, $attributes['items']);

                foreach ($items as $item) {
                    MenuItem::create($item);
                }
            }

            return $menu;
        });
    }

    public function update(array $attributes, $id)
    {
        return DB::transaction(function () use ($attributes, $id) {
            $menu = parent::update($attributes, $id);

            if (isset($attributes['items'])) {
                $items = $this->assignMenuIdAndIndex($menu, $attributes['items']);

                $existedItemIds = [];
                $this->traverseItem($items, function ($item) use (&$existedItemIds) {
                    if (isset($item['id'])) {
                        $existedItemIds[] = $item['id'];
                    }
                });

                $deleteItemIds = $menu->items()
                    ->whereNotIn('id', $existedItemIds)
                    ->pluck('id');

                MenuItem::rebuildTree($items, $deleteItemIds->toArray());
            }

            return $menu;
        });
    }

    public function delete($id): bool
    {
        return DB::transaction(function () use ($id) {
            $menu = $this->find($id);

            $menu->items()->delete();
            $menu->delete();

            return true;
        });
    }

    protected function assignMenuIdAndIndex($menu, $items) {
        $index = 0;
        return array_map(function ($item) use ($menu, &$index) {
            $item['menu_id'] = $menu->id;
            $item['index'] = $index++;

            if (isset($item['children'])) {
                $item['children'] = $this->assignMenuIdAndIndex($menu, $item['children']);
            }

            return $item;
        }, $items);
    }

    protected function traverseItem($items, $callback) {
        foreach ($items as $item) {
            $callback($item);

            if (isset($item['children'])) {
                $this->traverseItem($item['children'], $callback);
            }
        }
    }
}

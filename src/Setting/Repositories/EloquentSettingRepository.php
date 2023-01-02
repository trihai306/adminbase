<?php

namespace Modules\Setting\Repositories;

use Modules\Setting\Entities\Setting;

class EloquentSettingRepository implements SettingRepository
{
    private $model;

    public function __construct(Setting $model)
    {
        $this->model = $model;
    }

    public function query(array $conditions)
    {
        $query = $this->model->newQuery();

        if (isset($conditions['keys']) && is_array($conditions['keys'])) {
            $query->whereIn('key', $conditions['keys']);
        }

        $settings = $query->get();

        return $settings->mapWithKeys(function ($setting) {
            return [$setting->key => $setting->value];
        })->all();
    }

    public function get(string $key)
    {
        $setting = $this->model->newQuery()
            ->where('key', $key)
            ->first();

        return optional($setting)->value;
    }

    public function set(string $key, $value)
    {
        return $this->model->newQuery()->updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );
    }

    public function setMany(array $settings)
    {
        foreach ($settings as $key => $value) {
            $this->set($key, $value);
        }
    }
}

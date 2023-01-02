<?php

namespace Modules\Setting\Repositories;

interface SettingRepository
{
    public function query(array $conditions);
    public function get(string $key);
    public function set(string $key, $value);
    public function setMany(array $settings);
}

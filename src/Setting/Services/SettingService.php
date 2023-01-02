<?php

namespace Modules\Setting\Services;

use Modules\Setting\Repositories\SettingRepository;

class SettingService
{
    private $settingRepository;

    public function __construct(SettingRepository $settingRepository)
    {
        $this->settingRepository = $settingRepository;
    }

    public function get(string $key, $default = null)
    {
        $value = $this->settingRepository->get($key);

        return $value ?? $default;
    }

    public function set(string $key, $value)
    {
        return $this->settingRepository->set($key, $value);
    }
}

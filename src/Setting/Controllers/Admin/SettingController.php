<?php

namespace Modules\Setting\Controllers\Admin;

use Modules\Setting\Repositories\SettingRepository;
use Modules\Setting\Requests\Admin\ShowSettingRequest;
use Modules\Setting\Requests\Admin\UpdateSettingRequest;
use Modules\Setting\Transformers\SettingResource;

class SettingController
{
    private $settingRepository;

    public function __construct(SettingRepository $settingRepository)
    {
        $this->settingRepository = $settingRepository;
    }

    public function show(ShowSettingRequest $request)
    {
        $settings = $this->settingRepository->query(
            $request->validated()
        );

        return new SettingResource($settings);
    }

    public function update(UpdateSettingRequest $request)
    {
        $settings = $request->all();

        $this->settingRepository->setMany($settings);

        return new SettingResource($settings);
    }
}

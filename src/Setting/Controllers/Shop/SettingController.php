<?php

namespace Modules\Setting\Controllers\Shop;

use Modules\Core\Controllers\Controller;
use Modules\Setting\Repositories\SettingRepository;
use Modules\Setting\Requests\Shop\ShowSettingRequest;
use Modules\Setting\Transformers\SettingResource;

class SettingController extends Controller
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
}

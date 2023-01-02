<?php

namespace Modules\Catalog\Console;

use Illuminate\Support\Facades\DB;
use Modules\Catalog\Repositories\OptionRepository;

class MigrateOptionCommand extends MigrateCommand
{
    protected $name = 'migrate:option';

    protected $description = 'Migrate product from old database.';

    public function handle(OptionRepository $optionRepository)
    {
        $this->setupOldDatabaseConnection();

        $oldAreaOptionValues = DB::connection('old_mysql')
            ->table('areas')
            ->get();
        $this->createOption($optionRepository, $oldAreaOptionValues, [
            'code' => 'khu-vuc',
            'name' => 'Khu vực',
            'image' => null,
            'description' => null,
        ]);

        $oldPlatformOptionValues = DB::connection('old_mysql')
            ->table('brands')
            ->get();
        $this->createOption($optionRepository, $oldPlatformOptionValues, [
            'code' => 'nen-tang',
            'name' => 'Nền tảng',
            'image' => null,
            'description' => null,
        ]);

        $oldSystemOptionValues = DB::connection('old_mysql')
            ->table('platforms')
            ->get();
        $this->createOption($optionRepository, $oldSystemOptionValues, [
            'code' => 'he-dieu-hanh',
            'name' => 'Hệ điều hành',
            'image' => null,
            'description' => null,
        ]);

        $oldProductTypeOptionValues = DB::connection('old_mysql')
            ->table('product_types')
            ->get();
        $this->createOption($optionRepository, $oldProductTypeOptionValues, [
            'code' => 'loai-san-pham',
            'name' => 'Loại sản phẩm',
            'image' => null,
            'description' => null,
        ]);
    }

    protected function createOption($optionRepository, $values, array $attributes)
    {
        $optionRepository->create(array_merge($attributes, [
            'values' => $values->map(function ($value) {
                return [
                    'code' => $value->name,
                    'name' => $value->name,
                    'image' => $this->storeMediaImage($value->image),
                    'description' => $value->description,
                ];
            })
        ]));
    }
}

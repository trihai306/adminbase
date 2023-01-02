<?php

namespace Modules\User\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\User\Entities\IdentifyProvider;

class IdentifyProvidersTableSeeder extends Seeder
{
    public function run()
    {
        Model::unguard();

        $identifyProviders = [
            'google' => 'Google',
            'facebook' => 'Facebook',
            'steam' => 'Steam',
            'discord' => 'Discord',
            'tiktok' => 'Tiktok'
        ];

        foreach ($identifyProviders as $code => $name) {
            IdentifyProvider::updateOrCreate([
                'code' => $code,
                'name' => $name
            ]);
        }
    }
}

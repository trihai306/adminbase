<?php

namespace Modules\Media\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class MediaFileArray implements CastsAttributes
{
    public function get($model, string $key, $value, array $attributes)
    {
        $paths = json_decode($value);

        if (!$paths) return [];

        return array_map(function ($path) {
            return new File($path);
        }, $paths);
    }

    public function set($model, string $key, $value, array $attributes)
    {
        if (!$value) {
            return [$key => json_encode([])];
        }

        $paths = array_map(function ($file) {
            if (!$file instanceof File) {
                return $file;
            }

            return $file->path;
        }, $value);

        return [$key => json_encode($paths)];
    }
}

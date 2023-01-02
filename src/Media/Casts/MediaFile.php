<?php

namespace Modules\Media\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class MediaFile implements CastsAttributes
{
    public function get($model, string $key, $value, array $attributes)
    {
        return $value ? new File($value) : null;
    }

    public function set($model, string $key, $value, array $attributes)
    {
        if (!$value instanceof File) {
            return [$key => $value];
        }

        return [$key => $value->path];
    }
}

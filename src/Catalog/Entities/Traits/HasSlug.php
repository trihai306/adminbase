<?php

namespace Modules\Catalog\Entities\Traits;

use Modules\Appearance\Entities\Slug;

trait HasSlug
{
    public function slug()
    {
        return $this->morphOne(Slug::class, 'slugable');
    }
}

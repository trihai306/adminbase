<?php

namespace Modules\Appearance\Repositories;

use Modules\Core\Repositories\Repository;

interface SlugRepository extends Repository
{
    public function findBySlug($slug);
}

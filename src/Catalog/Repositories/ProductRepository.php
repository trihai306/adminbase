<?php

namespace Modules\Catalog\Repositories;

use Modules\Core\Repositories\Repository;

interface ProductRepository extends Repository
{
    public function queryNewest(array $conditions);
    public function queryRecommendation(array $conditions);
    public function queryBestselling(array $conditions);
    public function queryUnder100k(array $conditions);
    public function queryHighReview(array $conditions);
}

<?php

namespace Modules\User\Repositories;

use Modules\Core\Repositories\EloquentRepository;
use Modules\User\Entities\Wishlist;

class EloquentWishlistRepository extends EloquentRepository implements WishlistRepository
{
    protected $allowedSorts = [
        'id',
        'product_id',
        'updated_at',
        'created_at'
    ];

    protected $allowedIncludes = [
        'product',
        'product.default_variant'
    ];

    public function __construct(Wishlist $model)
    {
        parent::__construct($model);
    }

    public function query(array $conditions)
    {
        $query = $this->model->newQuery();

        if (isset($conditions['user_id'])) {
            $query->where('user_id', $conditions['user_id']);
        }

        return parent::executeQuery($conditions, $query);
    }
}

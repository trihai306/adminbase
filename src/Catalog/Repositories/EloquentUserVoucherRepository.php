<?php

namespace Modules\Catalog\Repositories;

use Modules\Catalog\Entities\Brand;
use Modules\Catalog\Entities\UserVoucher;
use Modules\Catalog\Entities\Voucher;
use Modules\Catalog\Enums\VoucherStatus;
use Modules\Core\Repositories\EloquentRepository;

class EloquentUserVoucherRepository extends EloquentRepository implements UserVoucherRepository
{
    protected $allowedSearch = true;

    protected $allowedFilters = [

    ];

    protected $allowedSorts = [
        'id'
    ];

    protected $allowedIncludes = [
        'voucher','voucher.variants'
    ];

    public function __construct(UserVoucher $model)
    {
        parent::__construct($model);
    }

    public function query(array $conditions)
    {
        $query = $this->model->newQuery();
        if(isset($conditions['user_id'])){
            $query->where('user_id',$conditions['user_id']);
        }
        return $this->executeQuery($conditions, $query);
    }

}

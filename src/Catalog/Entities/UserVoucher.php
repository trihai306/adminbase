<?php

namespace Modules\Catalog\Entities;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Modules\Catalog\Enums\VoucherStatus;
use Modules\Catalog\Enums\VoucherType;
use Modules\Core\Scopes\StatusScope;
use Modules\User\Entities\User;

class UserVoucher extends Model
{
    use HasFactory;
    protected $table = "user_voucher";
    protected $guarded = [];


    protected static function booted()
    {
        if (request()->isShopApi()) {
            static::addGlobalScope(new StatusScope(VoucherStatus::ACTIVATED));
        }
    }

    public function users(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function voucher(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Voucher::class, 'voucher_id');
    }
}

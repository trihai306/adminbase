<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'amount',
        'balance',
        'content'
    ];

    public function scopeSearch(Builder $builder, $keyword)
    {
        return $builder->where(function ($query) use ($keyword) {
            return $query->whereHas('user', function ($query) use ($keyword) {
                    return $query->search($keyword);
                })
                ->orWhere('content', 'like', "%$keyword%");
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected static function newFactory()
    {
        return \Modules\User\Database\factories\TransactionFactory::new();
    }
}

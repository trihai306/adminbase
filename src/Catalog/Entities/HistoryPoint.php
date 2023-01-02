<?php

namespace Modules\Catalog\Entities;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\User\Entities\User;

class HistoryPoint extends Model
{
    use HasFactory;

    protected $table = 'history_points';
    protected $guarded = [];

    public function scopeSearch(Builder $builder, $keyword)
    {
        return $builder->where(function ($query) use ($keyword){
            $query->where('id','like',"%$keyword%");
            $query->orWhere('point','like',"%$keyword%");
            $query->orWhere('note','like',"%$keyword%");
        });
    }
    public function users(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
}

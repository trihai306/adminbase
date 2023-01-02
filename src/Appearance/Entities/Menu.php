<?php

namespace Modules\Appearance\Entities;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name'
    ];

    public function scopeSearch(Builder $builder, $keyword): Builder
    {
        return $builder->where(function ($query) use ($keyword) {
            return $query->where('code', 'like', "%$keyword%")
                ->orWhere('name', 'like', "%$keyword%");
        });
    }

    public function items()
    {
        return $this->hasMany(MenuItem::class)
            ->orderBy('index');
    }

    protected static function newFactory()
    {
        return \Modules\Appearance\Database\factories\MenuFactory::new();
    }
}

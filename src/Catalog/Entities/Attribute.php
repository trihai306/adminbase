<?php

namespace Modules\Catalog\Entities;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Catalog\Enums\AttributeType;

class Attribute extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'type'
    ];

    protected $casts = [
        'type' => AttributeType::class
    ];

    public function scopeSearch(Builder $builder, $keyword)
    {
        return $builder->where('name', 'like', "%$keyword%");
    }

    protected static function newFactory()
    {
        return \Modules\Catalog\Database\factories\AttributeFactory::new();
    }
}

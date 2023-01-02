<?php

namespace Modules\Catalog\Entities;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Media\Casts\MediaFile;

class Option extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'image',
        'description'
    ];

    protected $casts = [
        'image' => MediaFile::class
    ];

    public function scopeSearch(Builder $builder, $keyword)
    {
        return $builder->where('name', 'like', "%$keyword%");
    }

    public function values(): HasMany
    {
        return $this->hasMany(OptionValue::class);
    }

    protected static function newFactory()
    {
        return \Modules\Catalog\Database\factories\OptionFactory::new();
    }
}

<?php

namespace Modules\Catalog\Entities;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Modules\Catalog\Database\factories\CollectionFactory;
use Modules\Catalog\Entities\Traits\HasSlug;
use Modules\Media\Casts\MediaFile;

class Collection extends Model
{
    use HasFactory;
    use HasSlug;

    protected $fillable = [
        'code',
        'name',
        'image'
    ];

    protected $casts = [
        'image' => MediaFile::class
    ];

    public function scopeSearch(Builder $builder, $keyword)
    {
        return $builder->where('name', 'like', "%$keyword%");
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_collection');
    }

    protected static function newFactory()
    {
        return CollectionFactory::new();
    }
}

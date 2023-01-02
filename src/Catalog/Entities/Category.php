<?php

namespace Modules\Catalog\Entities;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Kalnoy\Nestedset\NodeTrait;
use Modules\Catalog\Database\factories\CategoryFactory;
use Modules\Catalog\Entities\Traits\HasSlug;
use Modules\Media\Casts\MediaFile;

class Category extends Model
{
    use HasFactory;
    use NodeTrait;
    use HasSlug;

    protected $with = [
        'slug'
    ];

    protected $fillable = [
        'parent_id',
        'code',
        'name',
        'icon',
        'image'
    ];

    protected $casts = [
        'icon' => MediaFile::class,
        'image' => MediaFile::class
    ];

    public function scopeSearch(Builder $builder, $keyword)
    {
        return $builder->where('name', 'like', "%$keyword%");
    }

    public function scopeIsRoot(Builder $builder, $isRoot = true)
    {
        return $isRoot ? $builder->whereNull('parent_id')
            : $builder->whereNotNull('parent_id');
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_category');
    }

    public function tags()
    {
        return $this->belongsToMany(CategoryTag::class, 'category_category_tag');
    }

    public function tag_ids()
    {
        return $this->tags()->select('id');
    }

    public function children_tags()
    {
        return $this->belongsToMany(CategoryTag::class, 'children_category_tag');
    }

    public function children_tag_ids()
    {
        return $this->children_tags()->select('id');
    }

    protected static function newFactory()
    {
        return CategoryFactory::new();
    }
}

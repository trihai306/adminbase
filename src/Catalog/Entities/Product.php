<?php

namespace Modules\Catalog\Entities;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Modules\Catalog\Database\factories\ProductFactory;
use Modules\Catalog\Entities\Traits\HasSlug;
use Modules\Catalog\Enums\ProductStatus;
use Modules\Catalog\Enums\VariantMatchingMethod;
use Modules\Core\Scopes\StatusScope;
use Modules\Media\Casts\MediaFile;
use Modules\Media\Casts\MediaFileArray;

class Product extends Model
{
    use HasFactory;
    use HasSlug;

    protected $with = [
        'slug'
    ];

    protected $fillable = [
        'code',
        'name',
        'image',
        'images',
        'category_id',
        'brand_id',
        'variant_matching_method',
        'initial_sold_count',
        'important_message',
        'status'
    ];

    protected $casts = [
        'image' => MediaFile::class,
        'images' => MediaFileArray::class,
        'variant_matching_method' => VariantMatchingMethod::class,
        'sold_count' => 'integer',
        'ratings_count' => 'integer',
        'ratings_avg_rating' => 'float',
        'status' => ProductStatus::class
    ];

    protected static function booted()
    {
        if (request()->isShopApi()) {
            static::addGlobalScope(new StatusScope(ProductStatus::PUBLISHED));
        }
    }

    public function getSoldCountAttribute()
    {
        return $this->initial_sold_count;
    }

    public function scopeSearch(Builder $builder, $keyword)
    {
        return $builder->where('name', 'like', "%$keyword%");
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'product_category');
    }

    public function category_ids()
    {
        return $this->categories()->select('id');
    }

    public function attributes(): BelongsToMany
    {
        return $this->belongsToMany(Attribute::class, 'product_attribute');
    }

    public function attribute_ids()
    {
        return $this->attributes()->select('id');
    }

    public function options(): BelongsToMany
    {
        return $this->belongsToMany(Option::class, 'product_option');
    }

    public function option_ids()
    {
        return $this->options()->select('id');
    }

    public function default_variant(): HasOne
    {
        return $this->defaultVariant();
    }

    public function defaultVariant(): HasOne
    {
        return $this->hasOne(Variant::class)->default();
    }

    public function variants(): HasMany
    {
        return $this->hasMany(Variant::class);
    }

    public function collections(): BelongsToMany
    {
        return $this->belongsToMany(Collection::class, 'product_collection');
    }

    public function collection_ids()
    {
        return $this->collections()->select('id');
    }

    public function promotions(): BelongsToMany
    {
        return $this->belongsToMany(Promotion::class, 'promotion_product');
    }

    public function related_product_ids()
    {
        return $this->relatedProducts()->select('id');
    }

    public function related_products()
    {
        return $this->relatedProducts();
    }

    public function relatedProducts()
    {
        return $this->belongsToMany(
            self::class,
            'related_product',
            'product_id',
            'related_product_id'
        );
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function ratings()
    {
        return $this->reviews()->rating();
    }

    protected static function newFactory()
    {
        return ProductFactory::new();
    }
}

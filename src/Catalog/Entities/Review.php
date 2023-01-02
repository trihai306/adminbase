<?php

namespace Modules\Catalog\Entities;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\User\Entities\User;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_id',
        'reviewer_id',
        'product_id',
        'variant_id',
        'order_item_id',
        'rating',
        'comment'
    ];

    protected $casts = [
        'rating' => 'integer'
    ];

    public function scopeRating(Builder $builder)
    {
        return $builder->whereNotNull('rating');
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function replies()
    {
        return $this->hasMany(Review::class, 'parent_id');
    }

    protected static function newFactory()
    {
        return \Modules\Catalog\Database\factories\ReviewFactory::new();
    }
}

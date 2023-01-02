<?php

namespace Modules\Cart\Entities;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Collection;
use Modules\Core\Entities\Model;

class Cart extends Model
{
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'items'
    ];

    public function __construct()
    {
        parent::__construct([
            'id' => Str::uuid(),
            'items' => new Collection()
        ]);
    }

    public function getTotalAttribute()
    {
        return $this->items->reduce(function ($total, $item) {
            return $total + $item->total;
        }, 0);
    }
}

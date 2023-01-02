<?php

namespace Modules\Cart\Repositories;

use Illuminate\Contracts\Cache\Repository;
use Modules\Cart\Entities\Cart;
use Modules\Cart\Entities\CartItem;

class EloquentCartRepository implements CartRepository
{
    private $repository;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    public function find($id)
    {
        return $this->repository->get("carts.$id");
    }

    public function create(array $attributes)
    {
        return $this->store(new Cart());
    }

    public function addItem($id, $attributes)
    {
        $cart = $this->find($id);

        $cartItem = new CartItem($attributes);
        $cart->items->put($cartItem->id, $cartItem);

        return $this->store($cart);
    }

    public function updateItem($id, $itemId, $quantity)
    {
        $cart = $this->find($id);

        $item = $cart->items->get($itemId);

        $item->quantity = $quantity;

        return $this->store($cart);
    }

    public function deleteItem($id, $itemId)
    {
        $cart = $this->find($id);

        $cart->items->forget($itemId);

        return $this->store($cart);
    }

    public function delete($id)
    {
        $this->repository->forget($this->cacheKey($id));
    }

    protected function cacheKey($id): string
    {
        return "carts.$id";
    }

    protected function store(Cart $cart)
    {
        $this->repository->put($this->cacheKey($cart->id), $cart);

        return $cart;
    }
}

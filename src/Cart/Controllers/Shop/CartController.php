<?php

namespace Modules\Cart\Controllers\Shop;

use Modules\Cart\Repositories\CartRepository;
use Modules\Cart\Transformers\CartResource;
use Modules\Core\Controllers\Controller;

class CartController extends Controller
{
    private $cartRepository;

    public function __construct(CartRepository $cartRepository)
    {
        $this->cartRepository = $cartRepository;
    }

    public function store()
    {
        $cart = $this->cartRepository->create([]);

        return new CartResource($cart);
    }

    public function show($id)
    {
        $cart = $this->cartRepository->find($id);

        return new CartResource($cart);
    }
}

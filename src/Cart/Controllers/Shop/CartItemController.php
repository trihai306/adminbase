<?php

namespace Modules\Cart\Controllers\Shop;

use Modules\Cart\Repositories\CartRepository;
use Modules\Cart\Requests\Shop\StoreCartItemRequest;
use Modules\Cart\Requests\Shop\UpdateCartItemRequest;
use Modules\Cart\Services\CartService;
use Modules\Cart\Transformers\CartResource;
use Modules\Core\Controllers\Controller;

class CartItemController extends Controller
{
    private $cartRepository;
    private $cartService;

    public function __construct(
        CartRepository $cartRepository,
        CartService $cartService
    )
    {
        $this->cartRepository = $cartRepository;
        $this->cartService = $cartService;
    }

    public function store($cartId, StoreCartItemRequest $request)
    {
        $cart = $this->cartRepository->find($cartId);

        $cart = $this->cartService->addItem(
            $cart->id,
            $request->input('variant_id'),
            $request->input('quantity')
        );

        return new CartResource($cart);
    }

    public function update($cartId, $itemId, UpdateCartItemRequest $request)
    {
        $cart = $this->cartRepository->find($cartId);
        $quantity = $request->input('quantity');

        if ($quantity > 0) {
            $cart = $this->cartService->updateItem(
                $cart->id,
                $itemId,
                $request->input('quantity')
            );
        } else {
            $cart = $this->cartService->deleteItem($cartId, $itemId);
        }

        return new CartResource($cart);
    }

    public function destroy($cartId, $itemId)
    {
        $cart = $this->cartService->deleteItem($cartId, $itemId);

        return new CartResource($cart);
    }
}

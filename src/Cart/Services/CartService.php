<?php

namespace Modules\Cart\Services;

use Modules\Cart\Exceptions\OutOfStockException;
use Modules\Cart\Repositories\CartRepository;
use Modules\Catalog\Repositories\VariantRepository;

class CartService
{
    private $cartRepository;
    private $variantRepository;

    public function __construct(
        CartRepository $cartRepository,
        VariantRepository $variantRepository
    )
    {
        $this->cartRepository = $cartRepository;
        $this->variantRepository = $variantRepository;
    }

    public function addItem($id, $variantId, $quantity)
    {
        $cart = $this->cartRepository->find($id);
        $variant = $this->variantRepository->find($variantId);

        $cartItem = $cart->items->first(function ($item) use ($variantId) {
            return $item->variant_id == $variantId;
        });

        if ($cartItem) {
            $totalQuantity = $cartItem->quantity + $quantity;

            if ($variant->isOutOfStock($totalQuantity)) {
                throw new OutOfStockException($variant);
            }

            return $this->cartRepository->updateItem($id, $cartItem->id, $totalQuantity);
        } else {
            if ($variant->isOutOfStock($quantity)) {
                throw new OutOfStockException($variant);
            }

            return $this->cartRepository->addItem($id, [
                'variant_id' => $variant->id,
                'code' => $variant->code,
                'name' => $variant->name,
                'image' => $variant->image->path,
                'price' => $variant->price,
                'discount_price' => $variant->discount_price,
                'sale_price' => $variant->sale_price,
                'quantity' => $quantity,
                'order_type' => $variant->order_type
            ]);
        }
    }

    public function updateItem($id, $itemId, $quantity)
    {
        return $this->cartRepository->updateItem($id, $itemId, $quantity);
    }

    public function deleteItem($id, $itemId)
    {
        return $this->cartRepository->deleteItem($id, $itemId);
    }

    public function deleteItemIds($id, $itemIds)
    {
        foreach ($itemIds as $itemId) {
            $this->cartRepository->deleteItem($id, $itemId);
        }
    }

    public function delete($id)
    {
        return $this->cartRepository->delete($id);
    }
}

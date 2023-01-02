<?php

namespace Modules\Order\Services;

use Illuminate\Support\Facades\DB;
use Modules\Cart\Exceptions\OutOfStockException;
use Modules\Cart\Exceptions\PriceChangedException;
use Modules\Catalog\Repositories\VariantRepository;
use Modules\Order\Enums\OrderItemStatus;
use Modules\Order\Enums\OrderStatus;
use Modules\Order\Events\NewOrder;
use Modules\Order\Events\OrderCanceled;
use Modules\Order\Events\OrderPaid;
use Modules\Order\Repositories\OrderRepository;
use Modules\Payment\Enums\PaymentType;
use Modules\Payment\Repositories\PaymentMethodRepository;
use Modules\Payment\Services\PaymentService;

class OrderService
{
    private $orderRepository;
    private $paymentMethodRepository;
    private $paymentService;
    private $variantRepository;

    public function __construct(
        OrderRepository $orderRepository,
        PaymentMethodRepository $paymentMethodRepository,
        PaymentService $paymentService,
        VariantRepository $variantRepository
    ) {
        $this->orderRepository = $orderRepository;
        $this->paymentMethodRepository = $paymentMethodRepository;
        $this->paymentService = $paymentService;
        $this->variantRepository = $variantRepository;
    }

    public function create(array $attributes)
    {
        return DB::transaction(function () use ($attributes) {
            foreach ($attributes['items'] as $item) {
                $variant = $this->variantRepository->find($item['variant_id']);

                if ($variant->sale_price !== $item['sale_price']) {
                    throw new PriceChangedException($variant);
                }

                if ($variant->isOutOfStock($item['quantity'])) {
                    throw new OutOfStockException($variant);
                }
            }

            $order = $this->orderRepository->create(array_merge($attributes, [
                'total' => collect($attributes['items'])->reduce(function ($total, $item) {
                    return $total + $item['sale_price'] * $item['quantity'];
                }, 0)
            ]));

            $paymentMethod = $this->paymentMethodRepository->find(
                $attributes['payment_method_id']
            );

            $this->paymentService->create(array_merge($attributes, [
                'type' => PaymentType::ORDER,
                'payer_id' => $order->buyer_id,
                'order_id' => $order->id,
                'method_id' => $paymentMethod->id,
                'amount' => $this->paymentService->calculateOrderAmount(
                    $paymentMethod->type->value,
                    $order->total,
                    $attributes
                )
            ]));

            NewOrder::dispatch($order);

            return $order;
        });
    }

    public function pay($id)
    {
        return DB::transaction(function () use ($id) {
            $order = $this->orderRepository->update([
                'status' => OrderStatus::PENDING
            ], $id);

            $order->items()->update([
                'status' => OrderItemStatus::PENDING
            ]);

            OrderPaid::dispatch($order);

            return $order;
        });
    }

    public function cancel($id)
    {
        return DB::transaction(function () use ($id) {
            $order = $this->orderRepository->update([
                'status' => OrderStatus::CANCELED
            ], $id);

            $order->items()->update([
                'status' => OrderItemStatus::CANCELED
            ]);

            OrderCanceled::dispatch($order);

            return $order;
        });
    }
}

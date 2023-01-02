<?php

namespace Modules\Order\Controllers\Shop;

use Modules\Cart\Repositories\CartRepository;
use Modules\Cart\Services\CartService;
use Modules\Core\Controllers\Controller;
use Modules\Order\Repositories\OrderRepository;
use Modules\Order\Requests\Shop\IndexOrderRequest;
use Modules\Order\Requests\Shop\StoreOrderRequest;
use Modules\Order\Services\OrderService;
use Modules\Order\Transformers\OrderCollection;
use Modules\Order\Transformers\OrderResource;
use Modules\User\Services\AuthenticationService;

class OrderController extends Controller
{
    private $orderRepository;
    private $orderService;
    private $cartRepository;
    private $cartService;
    private $authenticationService;

    public function __construct(
        OrderRepository $orderRepository,
        OrderService $orderService,
        CartRepository $cartRepository,
        CartService $cartService,
        AuthenticationService $authenticationService
    ) {
        $this->orderRepository = $orderRepository;
        $this->orderService = $orderService;
        $this->cartRepository = $cartRepository;
        $this->cartService = $cartService;
        $this->authenticationService = $authenticationService;
    }

    public function index(IndexOrderRequest $request)
    {
        $user = $this->authenticationService->currentUser();

        $orders = $this->orderRepository->query(
            array_merge($request->validated(), [
                'buyer_id' => $user->id
            ])
        );

        return new OrderCollection($orders);
    }

    public function store(StoreOrderRequest $request)
    {
        $user = $this->authenticationService->currentUser();
        $cart = $this->cartRepository->find($request->input('cart_id'));

        abort_if(!$cart, 404, 'Giỏ hàng không tồn tại.');

        $itemIds = $request->input('item_ids');
        $selectedCartItems = $cart->items->whereIn('id', $itemIds);

        abort_if($selectedCartItems->count() < count($itemIds), 401);

        $order = $this->orderService->create(array_merge($request->validated(), [
            'buyer_id' => $user->id,
            'items' => $selectedCartItems->map(function ($item) {
                return $item->toArray();
            })->all()
        ]));

        $this->cartService->deleteItemIds($cart->id, $request->input('item_ids'));

        $order = $this->orderRepository->query([
            'id' => $order->id
        ]);

        return new OrderResource($order);
    }

    public function show($id)
    {
        $user = $this->authenticationService->currentUser();

        $order = $this->orderRepository->query([
            'id' => $id,
            'buyer_id' => $user->id
        ]);

        return new OrderResource($order);
    }
}

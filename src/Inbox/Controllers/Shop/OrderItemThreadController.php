<?php

namespace Modules\Inbox\Controllers\Shop;

use Modules\Core\Controllers\Controller;
use Modules\Inbox\Repositories\ThreadRepository;
use Modules\Inbox\Transformers\ThreadResource;
use Modules\Order\Repositories\OrderItemRepository;
use Modules\Order\Repositories\OrderRepository;
use Modules\User\Services\AuthenticationService;

class OrderItemThreadController extends Controller
{
    private $authenticationService;
    private $threadRepository;
    private $orderRepository;
    private $orderItemRepository;

    public function __construct(
        AuthenticationService $authenticationService,
        ThreadRepository $threadRepository,
        OrderRepository $orderRepository,
        OrderItemRepository $orderItemRepository
    ) {
        $this->authenticationService = $authenticationService;
        $this->threadRepository = $threadRepository;
        $this->orderRepository = $orderRepository;
        $this->orderItemRepository = $orderItemRepository;
    }

    public function show($orderItemId)
    {
        $user = $this->authenticationService->currentUser();

        $orderItem = $this->orderItemRepository->find($orderItemId);
        $order = $this->orderRepository->find($orderItem->order_id);

        if ($order->buyer_id != $user->id) {
            return $this->respondError(
                'not_buyer',
                'Bạn không phải là người mua hàng.',
                404
            );
        }

        $thread = $this->threadRepository->findByOrderItemId($orderItem->id);

        if (!$thread) {
            $thread = $this->threadRepository->create([
                'subject' => "$orderItem->quantity x $orderItem->name",
                'order_id' => $orderItem->order_id,
                'customer_id' => $order->buyer_id,
                'order_item_id' => $orderItem->id,
                'participant_ids' => [$user->id, $order->buyer_id]
            ]);
        }

        $thread = $this->threadRepository->query([
            'id' => $thread->id
        ]);

        return new ThreadResource($thread);
    }
}

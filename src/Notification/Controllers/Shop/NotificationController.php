<?php

namespace Modules\Notification\Controllers\Shop;

use Modules\Core\Controllers\Controller;
use Modules\Notification\Repositories\NotificationRepository;
use Modules\Notification\Requests\Admin\ReadNotificationRequest;
use Modules\Notification\Requests\Shop\IndexNotificationRequest;
use Modules\Notification\Transformers\NotificationCollection;
use Modules\User\Services\AuthenticationService;

class NotificationController extends Controller
{
    private $authenticationService;
    private $notificationRepository;

    public function __construct(
        AuthenticationService $authenticationService,
        NotificationRepository $notificationRepository
    ) {
        $this->authenticationService = $authenticationService;
        $this->notificationRepository = $notificationRepository;
    }

    public function index(IndexNotificationRequest $request)
    {
        $user = $this->authenticationService->currentUser();

        $notifications = $this->notificationRepository->query(
            array_merge($request->validated(), [
                'user_id' => $user->id
            ])
        );

        return new NotificationCollection($notifications);
    }

    public function markAsRead(ReadNotificationRequest $request)
    {
        $this->notificationRepository->markAsRead($request->input('ids'));

        return $this->respondSuccess('Đánh dấu đã đọc thành công.');
    }
}

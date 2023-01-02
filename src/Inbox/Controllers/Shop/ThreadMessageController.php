<?php

namespace Modules\Inbox\Controllers\Shop;

use Modules\Core\Controllers\Controller;
use Modules\Inbox\Events\NewMessage;
use Modules\Inbox\Repositories\MessageRepository;
use Modules\Inbox\Repositories\ThreadRepository;
use Modules\Inbox\Requests\Shop\IndexThreadMessageRequest;
use Modules\Inbox\Requests\Shop\StoreThreadMessageRequest;
use Modules\Inbox\Transformers\MessageCollection;
use Modules\Inbox\Transformers\MessageResource;
use Modules\User\Services\AuthenticationService;

class ThreadMessageController extends Controller
{
    private $threadRepository;
    private $messageRepository;
    private $authenticationService;

    public function __construct(
        ThreadRepository $threadRepository,
        MessageRepository $messageRepository,
        AuthenticationService $authenticationService
    ) {
        $this->threadRepository = $threadRepository;
        $this->messageRepository = $messageRepository;
        $this->authenticationService = $authenticationService;
    }

    public function index($threadId, IndexThreadMessageRequest $request)
    {
        $user = $this->authenticationService->currentUser();

        $thread = $this->threadRepository->find($threadId);

        if (!$this->threadRepository->checkInParticipant($thread->id, $user->id)) {
            return $this->respondError(
                'cannot_send_message',
                'Không thể gửi tin nhắn.',
                404
            );
        }

        $messages = $this->messageRepository->query(
            array_merge($request->validated(), [
                'thread_id' => $thread->id
            ])
        );

        return new MessageCollection($messages);
    }

    public function store($threadId, StoreThreadMessageRequest $request)
    {
        $user = $this->authenticationService->currentUser();

        $thread = $this->threadRepository->find($threadId);

        $message = $this->messageRepository->create(
            array_merge($request->validated(), [
                'thread_id' => $thread->id,
                'sender_id' => $user->id
            ])
        );

        NewMessage::dispatch($message);

        return new MessageResource($message);
    }
}

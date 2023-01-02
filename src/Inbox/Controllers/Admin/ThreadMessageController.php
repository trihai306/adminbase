<?php

namespace Modules\Inbox\Controllers\Admin;

use Modules\Core\Controllers\Controller;
use Modules\Inbox\Events\NewMessage;
use Modules\Inbox\Repositories\MessageRepository;
use Modules\Inbox\Repositories\ThreadRepository;
use Modules\Inbox\Requests\Admin\IndexThreadMessageRequest;
use Modules\Inbox\Requests\Admin\StoreThreadMessageRequest;
use Modules\Inbox\Transformers\MessageCollection;
use Modules\Inbox\Transformers\MessageResource;
use Modules\User\Services\AuthenticationService;

class ThreadMessageController extends Controller
{
    private $authenticationService;
    private $threadRepository;
    private $messageRepository;

    public function __construct(
        AuthenticationService $authenticationService,
        ThreadRepository $threadRepository,
        MessageRepository $messageRepository
    ) {
        $this->authenticationService = $authenticationService;
        $this->threadRepository = $threadRepository;
        $this->messageRepository = $messageRepository;
    }

    public function index($threadId, IndexThreadMessageRequest $request)
    {
        $thread = $this->threadRepository->find($threadId);

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

        $this->threadRepository->markLastSeen($thread->id, $user->id);

        NewMessage::dispatch($message);

        $message = $this->messageRepository->query([
            'id' => $message->id
        ]);

        return new MessageResource($message);
    }
}

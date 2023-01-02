<?php

namespace Modules\Inbox\Controllers\Admin;

use Modules\Core\Controllers\Controller;
use Modules\Inbox\Repositories\ThreadRepository;
use Modules\Inbox\Requests\Admin\IndexThreadRequest;
use Modules\Inbox\Transformers\ThreadCollection;
use Modules\Inbox\Transformers\ThreadResource;
use Modules\User\Services\AuthenticationService;

class ThreadController extends Controller
{
    private $authenticationService;
    private $threadRepository;

    public function __construct(
        AuthenticationService $authenticationService,
        ThreadRepository $threadRepository
    ) {
        $this->authenticationService = $authenticationService;
        $this->threadRepository = $threadRepository;
    }

    public function index(IndexThreadRequest $request)
    {
        $threads = $this->threadRepository->query(
            $request->validated()
        );

        return new ThreadCollection($threads);
    }

    public function show($id)
    {
        $thread = $this->threadRepository->query([
            'id' => $id
        ]);

        return new ThreadResource($thread);
    }

    public function seen($id)
    {
        $user = $this->authenticationService->currentUser();

        $thread = $this->threadRepository->query([
            'id' => $id
        ]);

        $this->threadRepository->markLastSeen($id, $user->id);

        return new ThreadResource($thread);
    }
}

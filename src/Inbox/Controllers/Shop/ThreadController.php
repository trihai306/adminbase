<?php

namespace Modules\Inbox\Controllers\Shop;

use Modules\Core\Controllers\Controller;
use Modules\Inbox\Repositories\ThreadRepository;
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

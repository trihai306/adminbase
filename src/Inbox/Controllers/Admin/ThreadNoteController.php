<?php

namespace Modules\Inbox\Controllers\Admin;

use Modules\Core\Controllers\Controller;
use Modules\Inbox\Repositories\NoteRepository;
use Modules\Inbox\Repositories\ThreadRepository;
use Modules\Inbox\Requests\Admin\IndexThreadMessageRequest;
use Modules\Inbox\Requests\Admin\StoreThreadNoteRequest;
use Modules\Inbox\Requests\Admin\UpdateThreadNoteRequest;
use Modules\Inbox\Transformers\NoteCollection;
use Modules\Inbox\Transformers\NoteResource;
use Modules\User\Services\AuthenticationService;

class ThreadNoteController extends Controller
{
    private $authenticationService;
    private $threadRepository;
    private $noteRepository;

    public function __construct(
        AuthenticationService $authenticationService,
        ThreadRepository $threadRepository,
        NoteRepository $noteRepository
    ) {
        $this->authenticationService = $authenticationService;
        $this->threadRepository = $threadRepository;
        $this->noteRepository = $noteRepository;
    }

    public function index($threadId, IndexThreadMessageRequest $request)
    {
        $thread = $this->threadRepository->find($threadId);

        $notes = $this->noteRepository->query(
            array_merge($request->validated(), [
                'thread_id' => $thread->id
            ])
        );

        return new NoteCollection($notes);
    }

    public function store($threadId, StoreThreadNoteRequest $request)
    {
        $user = $this->authenticationService->currentUser();
        $thread = $this->threadRepository->find($threadId);

        $note = $this->noteRepository->create(
            array_merge($request->validated(), [
                'thread_id' => $thread->id,
                'user_id' => $user->id
            ])
        );

        $note = $this->noteRepository->query([
            'id' => $note->id
        ]);

        return new NoteResource($note);
    }

    public function update($threadId, $noteId, UpdateThreadNoteRequest $request)
    {
        $user = $this->authenticationService->currentUser();
        $thread = $this->threadRepository->find($threadId);
        $note = $this->noteRepository->find($noteId);

        if ($note->user_id != $user->id || $note->thread_id != $thread->id) {
            return $this->respondError('not_own', '');
        }

        $note = $this->noteRepository->update($request->validated(), $noteId);

        $note = $this->noteRepository->query([
            'id' => $note->id
        ]);

        return new NoteResource($note);
    }

    public function destroy($threadId, $noteId)
    {
        $user = $this->authenticationService->currentUser();
        $thread = $this->threadRepository->find($threadId);
        $note = $this->noteRepository->find($noteId);

        if ($note->user_id != $user->id || $note->thread_id != $thread->id) {
            return $this->respondError('not_own', '');
        }

        $this->noteRepository->delete($noteId);

        return $this->respondSuccess('Xóa ghi chú thành công.');
    }
}

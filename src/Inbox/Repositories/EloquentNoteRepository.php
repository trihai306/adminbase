<?php

namespace Modules\Inbox\Repositories;

use Modules\Core\Repositories\EloquentRepository;
use Modules\Inbox\Entities\Note;

class EloquentNoteRepository extends EloquentRepository implements NoteRepository
{
    protected $allowedSearch = true;

    protected $allowedSorts = [
        'id',
        'updated_at',
        'created_at'
    ];

    protected $allowedIncludes = [
        'thread',
        'user'
    ];

    public function __construct(Note $model)
    {
        parent::__construct($model);
    }

    public function query(array $conditions)
    {
        $query = $this->model->newQuery();

        if (isset($conditions['thread_id'])) {
            $query->where('thread_id', $conditions['thread_id']);
        }

        return $this->executeQuery($conditions, $query);
    }
}

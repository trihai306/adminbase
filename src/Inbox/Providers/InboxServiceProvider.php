<?php

namespace Modules\Inbox\Providers;

use Illuminate\Database\Eloquent\Factory;
use Modules\Core\Providers\ModuleServiceProvider;
use Modules\Inbox\Repositories\EloquentMessageRepository;
use Modules\Inbox\Repositories\EloquentNoteRepository;
use Modules\Inbox\Repositories\EloquentThreadRepository;
use Modules\Inbox\Repositories\MessageRepository;
use Modules\Inbox\Repositories\NoteRepository;
use Modules\Inbox\Repositories\ThreadRepository;

class InboxServiceProvider extends ModuleServiceProvider
{
    protected $moduleName = 'Inbox';

    protected $moduleNameLower = 'inbox';

    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
        $this->app->bind(ThreadRepository::class, EloquentThreadRepository::class);
        $this->app->bind(MessageRepository::class, EloquentMessageRepository::class);
        $this->app->bind(NoteRepository::class, EloquentNoteRepository::class);
    }
}

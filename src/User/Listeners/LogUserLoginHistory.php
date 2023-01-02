<?php

namespace Modules\User\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\User\Events\UserLoggedIn;
use Modules\User\Repositories\LoginHistoryRepository;

class LogUserLoginHistory
{
    private $loginHistoryRepository;

    public function __construct(LoginHistoryRepository $loginHistoryRepository)
    {
        $this->loginHistoryRepository = $loginHistoryRepository;
    }

    public function handle(UserLoggedIn $event)
    {
        $this->loginHistoryRepository->create([
            'user_id' => $event->user->id,
            'token_id' => $event->token->accessToken->id,
            'ip' => $event->ip,
            'agent' => $event->agent,
            'country' => 'Việt Nam'
        ]);
    }
}

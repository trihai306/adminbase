<?php

namespace Modules\User\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\User\Events\UserLoggedIn;
use Modules\User\Listeners\LogUserLoginHistory;
use SocialiteProviders\Discord\DiscordExtendSocialite;
use SocialiteProviders\Facebook\FacebookExtendSocialite;
use SocialiteProviders\Google\GoogleExtendSocialite;
use SocialiteProviders\Manager\SocialiteWasCalled;
use SocialiteProviders\Steam\SteamExtendSocialite;
use SocialiteProviders\TikTok\TikTokExtendSocialite;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        SocialiteWasCalled::class => [
            GoogleExtendSocialite::class,
            SteamExtendSocialite::class,
            FacebookExtendSocialite::class,
            DiscordExtendSocialite::class,
            TikTokExtendSocialite::class
        ],
        UserLoggedIn::class => [
            LogUserLoginHistory::class
        ]
    ];
}

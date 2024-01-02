<?php

declare(strict_types=1);

namespace App\Providers;

use App\Events\User\EmailChanging;
use App\Events\User\UserRegistered;
use App\Listeners\User\SendNewEmailVerifyMail;
use App\Listeners\User\SendRegisterVerifyMail;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        UserRegistered::class => [
            SendRegisterVerifyMail::class,
        ],

        EmailChanging::class => [
            SendNewEmailVerifyMail::class,
        ],
    ];

    public function boot(): void
    {
        //
    }

    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}

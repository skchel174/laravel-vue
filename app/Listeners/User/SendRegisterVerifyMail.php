<?php

declare(strict_types=1);

namespace App\Listeners\User;

use App\Events\User\UserRegistered;
use App\Mail\VerifyRegistration;
use App\Models\User\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendRegisterVerifyMail
{
    public function handle(UserRegistered $event): void
    {
        Mail::to($event->user->email)
            ->send(new VerifyRegistration($event->user));
    }
}

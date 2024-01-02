<?php

declare(strict_types=1);

namespace App\Listeners\User;

use App\Events\User\EmailChanging;
use App\Mail\VerifyEmail;
use App\Mail\VerifyRegistration;
use App\Models\User\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendNewEmailVerifyMail
{
    public function handle(EmailChanging $event): void
    {
        Mail::to($event->user->new_email)->send(new VerifyEmail($event->user));
    }
}

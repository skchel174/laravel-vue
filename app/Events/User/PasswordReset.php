<?php

declare(strict_types=1);

namespace App\Events\User;

use App\Models\User\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PasswordReset
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public readonly User $user)
    {
    }
}

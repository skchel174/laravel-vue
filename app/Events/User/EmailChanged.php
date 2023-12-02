<?php

declare(strict_types=1);

namespace App\Events\User;

use App\Models\User\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class EmailChanged
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public readonly User $user)
    {
    }
}

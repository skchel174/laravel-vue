<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

use App\Models\User\User;
use Illuminate\Database\Eloquent\Collection;

interface TopicRepositoryInterface
{
    public function getByUser(User $user): Collection;
}

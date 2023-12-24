<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

use App\Models\User\User;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;

interface CommentRepositoryInterface
{
    public function getBookmarksIds(User $user, array|Arrayable $commentsIds): Collection;
}

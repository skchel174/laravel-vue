<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\User\User;
use App\Repositories\Interfaces\CommentRepositoryInterface;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;

class CommentRepository implements CommentRepositoryInterface
{
    public function getBookmarksIds(User $user, array|Arrayable $commentsIds): Collection
    {
        return $user->bookmarkedComments()
            ->whereIn('id', $commentsIds)
            ->pluck('id');
    }
}

<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Comment\Comment;
use App\Models\User\User;

class CommentPolicy
{
    public function update(User $user, Comment $comment): bool
    {
        return $comment->isAuthor($user);
    }
}

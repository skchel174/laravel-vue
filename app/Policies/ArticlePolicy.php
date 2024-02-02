<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Article\Article;
use App\Models\User\User;

class ArticlePolicy
{
    public function update(User $user, Article $article): bool
    {
        return $article->author->is($user);
    }

    public function delete(User $user, Article $article): bool
    {
        return $article->author->is($user);
    }
}

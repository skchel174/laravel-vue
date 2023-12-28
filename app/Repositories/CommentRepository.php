<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Article\Article;
use App\Models\User\User;
use App\Repositories\Interfaces\CommentRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;

class CommentRepository implements CommentRepositoryInterface
{
    public function getIdsByArticle(Article $article): Collection
    {
        return $article->allComments()
            ->pluck('id');
    }

    public function getBookmarks(User $user): LengthAwarePaginator
    {
        return $user->bookmarkedComments()
            ->with('article')
            ->without('comments')
            ->orderBy('id', 'desc')
            ->paginate()
            ->withQueryString();
    }

    public function getBookmarksIds(User $user, array|Arrayable $commentsIds): Collection
    {
        return $user->bookmarkedComments()
            ->whereIn('id', $commentsIds)
            ->pluck('id');
    }
}

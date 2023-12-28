<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Article\Article;
use App\Models\Article\Status;
use App\Models\User\User;
use App\Repositories\Interfaces\ArticleRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;

class ArticleRepository implements ArticleRepositoryInterface
{
    public function getByAuthor(User $author, Status $status): LengthAwarePaginator
    {
        return $author->articles()
            ->withCount([
                'usersLiked as likes_count',
                'allComments as comments_count',
            ])
            ->with(['topics', 'cardImage'])
            ->withTrashed($status === Status::Deleted)
            ->where('status', $status)
            ->orderBy('id', 'desc')
            ->paginate()
            ->withQueryString();
    }

    public function getBookmarks(User $user): LengthAwarePaginator
    {
        return $user->bookmarkedArticles()
            ->withCount([
                'usersLiked as likes_count',
                'allComments as comments_count',
            ])
            ->with(['topics', 'cardImage'])
            ->where('status', Status::Published)
            ->orderBy('id', 'desc')
            ->paginate()
            ->withQueryString();
    }

    public function getBookmarksIds(User $user, array|Arrayable $articlesIds): Collection
    {
        return $user->bookmarkedArticles()
            ->whereIn('id', $articlesIds)
            ->where('status', Status::Published)
            ->pluck('id');
    }

    public function getLikesIds(User $user, array|Arrayable $articlesIds = []): Collection
    {
        return $user->likedArticles()
            ->whereIn('id', $articlesIds)
            ->where('status', Status::Published)
            ->pluck('id');
    }

    public function getById(int $id): Article
    {
        /** @var Article $article */
        $article = Article::query()
            ->withCount([
                'usersLiked as likes_count',
                'allComments as comments_count',
            ])
            ->with(['topics', 'tags', 'cardImage', 'comments', 'comments.comments'])
            ->where('status', Status::Published)
            ->findOrFail($id);

        return $article;
    }
}

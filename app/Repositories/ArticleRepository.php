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
            ->with(['topics'])
            ->withCount(['likes', 'relatedComments'])
            ->withTrashed($status === Status::Deleted)
            ->where('status', $status)
            ->orderBy('id', 'desc')
            ->paginate()
            ->withQueryString();
    }

    public function getBookmarks(User $user): LengthAwarePaginator
    {
        return $user->bookmarkedArticles()
            ->with(['topics'])
            ->withCount(['likes', 'relatedComments'])
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
            ->withCount(['likes', 'relatedComments'])
            ->with(['topics', 'tags', 'comments'])
            ->where('status', Status::Published)
            ->findOrFail($id);

        return $article;
    }
}

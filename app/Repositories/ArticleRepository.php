<?php

declare(strict_types=1);

namespace App\Repositories;

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
            ->with(['topics', 'cardImage'])
            ->where('status', Status::Published)
            ->orderBy('id', 'desc')
            ->paginate()
            ->withQueryString();
    }

    public function getBookmarksIds(User $user, array|Arrayable $articlesIds = []): Collection
    {
        $query = $user->bookmarkedArticles();

        if ($articlesIds) {
            $query->whereIn('id', $articlesIds);
        }

        return $query
            ->where('status', Status::Published)
            ->pluck('id');
    }
}

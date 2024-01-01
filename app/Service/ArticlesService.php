<?php

declare(strict_types=1);

namespace App\Service;

use App\Models\Article\Article;
use App\Models\Article\Status;
use App\Models\User\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class ArticlesService
{
    public function getById(int $id): Article
    {
        $query = Article::query();

        if ($user = Auth::user()) {
            $query->withExists([
                'likes as is_liked' => fn(Builder $query) => $query->whereId($user->id),
                'bookmarks as is_bookmarked' => fn(Builder $query) => $query->whereId($user->id),
            ]);
        }

        return $query->with(['topics', 'tags'])
            ->withCount('likes', 'bookmarks', 'relatedComments')
            ->whereStatus(Status::Published)
            ->findOrFail($id);
    }

    public function getByAuthor(User $author, Status $status): LengthAwarePaginator
    {
        $query = $author->articles();

        if ($user = Auth::user()) {
            $query->withExists([
                'likes as is_liked' => fn(Builder $query) => $query->whereId($user->id),
                'bookmarks as is_bookmarked' => fn(Builder $query) => $query->whereId($user->id),
            ]);
        }

        return $query->with(['topics', 'cardImage'])
            ->withCount(['likes', 'relatedComments'])
            ->withTrashed($status === Status::Deleted)
            ->whereStatus($status)
            ->orderBy('id', 'desc')
            ->paginate()
            ->withQueryString();
    }

    public function getBookmarkedByUser(User $user): LengthAwarePaginator
    {
        $query = $user->bookmarkedArticles();

        if ($authUser = Auth::user()) {
            $query->withExists([
                'likes as is_liked' => fn(Builder $query) => $query->whereId($authUser->id),
                'bookmarks as is_bookmarked' => fn(Builder $query) => $query->whereId($authUser->id),
            ]);
        }

        return $query->with(['topics'])
            ->withCount(['likes', 'relatedComments'])
            ->orderBy('id', 'desc')
            ->paginate();
    }
}

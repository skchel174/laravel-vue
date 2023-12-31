<?php

declare(strict_types=1);

namespace App\Service;

use App\Models\Article\Article;
use App\Models\Article\Status;
use App\Models\User\User;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

class ArticlesService
{
    public function __construct(private readonly StatefulGuard $authService)
    {
    }

    public function getById(int $id): Article
    {
        $query = Article::query();

        /** @var User $user */
        if ($user = $this->authService->user()) {
            $query->withExists([
                'likes as is_liked' => fn (Builder $query) => $query->whereId($user->id),
                'bookmarks as is_bookmarked' => fn (Builder $query) => $query->whereId($user->id),
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

        /** @var User $authUser */
        if ($user = $this->authService->user()) {
            $query->withExists([
                'likes as is_liked' => fn (Builder $query) => $query->whereId($user->id),
                'bookmarks as is_bookmarked' => fn (Builder $query) => $query->whereId($user->id),
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
}

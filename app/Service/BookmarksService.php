<?php

declare(strict_types=1);

namespace App\Service;

use App\Models\User\User;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class BookmarksService
{
    public function __construct(private readonly StatefulGuard $authService)
    {
    }

    public function getArticles(User $user): LengthAwarePaginator
    {
        $query = $user->bookmarkedArticles();

        /** @var User $authUser */
        if ($authUser = $this->authService->user()) {
            $query->withExists([
                'likes as is_liked' => fn (Builder $query) => $query->whereId($authUser->id),
                'bookmarks as is_bookmarked' => fn (Builder $query) => $query->whereId($authUser->id),
            ]);
        }

        return $query->with(['topics'])
            ->withCount(['likes', 'relatedComments'])
            ->orderBy('id', 'desc')
            ->paginate();
    }

    public function getComments(User $user): LengthAwarePaginator
    {
        $query = $user->bookmarkedComments();

        /** @var User $authUser */
        if ($authUser = $this->authService->user()) {
            $query->withExists([
                'bookmarks as is_bookmarked' => fn (Builder $query) => $query->whereId($authUser->id),
            ]);
        }

        return $query->with('article')
            ->without('comments')
            ->orderBy('id', 'desc')
            ->paginate();
    }
}

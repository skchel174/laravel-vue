<?php

declare(strict_types=1);

namespace App\Service;

use App\Models\User\User;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class CommentsService
{
    public function __construct(private readonly StatefulGuard $auth)
    {
    }

    public function getByAuthor(User $author): LengthAwarePaginator
    {
        $query = $author->comments();

        /** @var User $authUser */
        if ($authUser = $this->auth->user()) {
            $query->withExists([
                'bookmarks as is_bookmarked' => fn (Builder $query) => $query->whereId($authUser->id),
            ]);
        }

        return $query->with('article')
            ->orderBy('id', 'desc')
            ->paginate();
    }
}

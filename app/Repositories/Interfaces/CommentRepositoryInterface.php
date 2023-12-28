<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

use App\Models\Article\Article;
use App\Models\User\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;

interface CommentRepositoryInterface
{
    public function getIdsByArticle(Article $article): Collection;
    public function getBookmarks(User $user): LengthAwarePaginator;
    public function getBookmarksIds(User $user, array|Arrayable $commentsIds): Collection;
}

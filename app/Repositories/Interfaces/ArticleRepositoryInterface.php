<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

use App\Models\Article\Article;
use App\Models\Article\Status;
use App\Models\User\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;

interface ArticleRepositoryInterface
{
    public function getByAuthor(User $author, Status $status): LengthAwarePaginator;
    public function getBookmarks(User $user): LengthAwarePaginator;
    public function getBookmarksIds(User $user, array|Arrayable $articlesIds): Collection;
    public function getLikesIds(User $user, array|Arrayable $articlesIds): Collection;
    public function getById(int $id): Article;
}

<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Article\Status;
use App\Models\User\User;
use App\Repositories\Interfaces\ArticleRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ArticleRepository implements ArticleRepositoryInterface
{
    public function getByAuthor(User $author, Status $status): LengthAwarePaginator
    {
        return $author->articles()
            ->with(['topics'])
            ->withTrashed($status === Status::Deleted)
            ->where('status', $status)
            ->orderBy('id', 'desc')
            ->paginate()
            ->withQueryString();
    }
}

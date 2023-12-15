<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

use App\Models\Article\Status;
use App\Models\User\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ArticleRepositoryInterface
{
    public function getByAuthor(User $author, Status $status): LengthAwarePaginator;
}

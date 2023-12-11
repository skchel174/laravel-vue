<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\User\User;
use App\Repositories\Interfaces\TopicRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class TopicRepository implements TopicRepositoryInterface
{
    public function getByUser(User $user): Collection
    {
        return $user->topics()
            ->withCount(['subscribers', 'articles'])
            ->get();
    }
}

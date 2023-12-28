<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Resources\Topic\TopicResource;
use App\Http\Resources\User\UserResource;
use App\Models\User\User;
use App\Repositories\Interfaces\TopicRepositoryInterface;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController
{
    public function __construct(private readonly TopicRepositoryInterface $topicRepository)
    {
    }

    public function index(User $user): Response
    {
        $topics = $this->topicRepository->getByUser($user);

        return Inertia::render('User/Profile/ProfilePage', [
            'user' => new UserResource($user),
            'topics' => TopicResource::collection($topics),
        ]);
    }
}

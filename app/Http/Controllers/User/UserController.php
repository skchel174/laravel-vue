<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\Topic\TopicResource;
use App\Http\Resources\User\UserResource;
use App\Models\User\User;
use App\Repositories\Interfaces\TopicRepositoryInterface;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class UserController extends Controller
{
    public function __construct(private readonly TopicRepositoryInterface $topicRepository)
    {
    }

    public function profile(Request $request, User $user): Response
    {
        $topics = $this->topicRepository->getByUser($user);

        return Inertia::render('User/Profile/ProfilePage', [
            'user' => UserResource::make($user),
            'topics' => TopicResource::collection($topics),
        ]);
    }
}

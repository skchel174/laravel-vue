<?php

declare(strict_types=1);

namespace App\Http\Controllers\Cabinet;

use App\Http\Controllers\Controller;
use App\Http\Resources\Topic\TopicResource;
use App\Models\User\User;
use App\Repositories\Interfaces\TopicRepositoryInterface;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{
    public function __construct(private readonly TopicRepositoryInterface $topicRepository)
    {
    }

    public function index(Request $request): Response
    {
        /** @var User $user */
        $user = $request->user();
        $topics = $this->topicRepository->getByUser($user);

        return Inertia::render('Cabinet/Profile/ProfilePage', [
            'topics' => TopicResource::collection($topics),
        ]);
    }
}

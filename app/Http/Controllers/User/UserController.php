<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\Article\ArticleListResource;
use App\Http\Resources\Topic\TopicResource;
use App\Http\Resources\User\UserResource;
use App\Models\Article\Status;
use App\Models\User\User;
use App\Repositories\Interfaces\ArticleRepositoryInterface;
use App\Repositories\Interfaces\TopicRepositoryInterface;
use App\Service\MarkReactionService;
use Illuminate\Contracts\Auth\StatefulGuard;
use Inertia\Inertia;
use Inertia\Response;

class UserController extends Controller
{
    public function __construct(
        private readonly StatefulGuard $authService,
        private readonly TopicRepositoryInterface $topicRepository,
        private readonly ArticleRepositoryInterface $articleRepository,
        private readonly MarkReactionService $reactionService,
    ) {
    }

    public function profile(User $user): Response
    {
        $topics = $this->topicRepository->getByUser($user);

        return Inertia::render('User/Profile/ProfilePage', [
            'user' => new UserResource($user),
            'topics' => TopicResource::collection($topics),
        ]);
    }

    public function articles(User $user, Status $status = Status::Published): Response
    {
        $articles = $this->articleRepository->getByAuthor($user, $status);

        /** @var User|null $authUser */
        if ($authUser = $this->authService->user()) {
            $this->reactionService->markArticles($authUser, $articles->items());
        }

        return Inertia::render('User/Articles/ArticlesPage', [
            'status' => $status->value,
            'statuses' => Status::cases(),
            'articles' => new ArticleListResource($articles),
            'user' => new UserResource($user),
        ]);
    }

    public function bookmarkedArticles(User $user): Response
    {
        $articles = $this->articleRepository->getBookmarks($user);

        /** @var User|null $authUser */
        if ($authUser = $this->authService->user()) {
            $this->reactionService->markArticles($authUser, $articles->items());
        }

        return Inertia::render('User/Bookmarks/ArticlesPage', [
            'user' => new UserResource($user),
            'articles' => new ArticleListResource($articles),
        ]);
    }
}

<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\Article\ArticleListResource;
use App\Http\Resources\Topic\TopicResource;
use App\Http\Resources\User\UserResource;
use App\Models\Article\Article;
use App\Models\Article\Status;
use App\Models\User\User;
use App\Repositories\Interfaces\ArticleRepositoryInterface;
use App\Repositories\Interfaces\TopicRepositoryInterface;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Support\Arr;
use Inertia\Inertia;
use Inertia\Response;

class UserController extends Controller
{
    public function __construct(
        private readonly StatefulGuard $authService,
        private readonly TopicRepositoryInterface $topicRepository,
        private readonly ArticleRepositoryInterface $articleRepository,
    ) {
    }

    public function profile(User $user): Response
    {
        $topics = $this->topicRepository->getByUser($user);

        return Inertia::render('User/Profile/ProfilePage', [
            'user' => UserResource::make($user),
            'topics' => TopicResource::collection($topics),
        ]);
    }

    public function articles(User $author, Status $status = Status::Published): Response
    {
        $articles = $this->articleRepository->getByAuthor($author, $status);

        /** @var User|null $user */
        if ($user = $this->authService->user()) {
            $articlesIds = Arr::pluck($articles->items(), 'id');
            $bookmarksIds = $this->articleRepository->getBookmarksIds($user, $articlesIds);

            foreach ($articles->items() as $article) {
                /** @var Article $article */
                $article->is_bookmarked = $bookmarksIds->contains($article->id);
            }
        }

        return Inertia::render('User/Articles/ArticlesPage', [
            'articles' => new ArticleListResource($articles),
            'statuses' => Status::cases(),
            'status' => $status->value,
            'user' => $author,
        ]);
    }
}

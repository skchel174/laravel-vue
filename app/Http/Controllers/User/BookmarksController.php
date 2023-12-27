<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\Article\ArticleListResource;
use App\Http\Resources\User\UserResource;
use App\Models\User\User;
use App\Repositories\Interfaces\ArticleRepositoryInterface;
use App\Service\MarkReactionService;
use Illuminate\Contracts\Auth\StatefulGuard;
use Inertia\Inertia;
use Inertia\Response;

class BookmarksController extends Controller
{
    public function __construct(
        private readonly StatefulGuard $authService,
        private readonly ArticleRepositoryInterface $articleRepository,
        private readonly MarkReactionService $reactionService,
    ) {
    }

    public function articles(User $user): Response
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

<?php

declare(strict_types=1);

namespace App\Http\Controllers\Article;

use App\Http\Controllers\Controller;
use App\Http\Resources\Article\ArticleResource;
use App\Models\User\User;
use App\Repositories\Interfaces\ArticleRepositoryInterface;
use App\Repositories\Interfaces\CommentRepositoryInterface;
use App\Service\MarkReactionService;
use Illuminate\Contracts\Auth\StatefulGuard;
use Inertia\Inertia;
use Inertia\Response;

class ArticleController extends Controller
{
    public function __construct(
        private readonly ArticleRepositoryInterface $articleRepository,
        private readonly CommentRepositoryInterface $commentRepository,
        private readonly MarkReactionService $reactionService,
        private readonly StatefulGuard $authService,
    ) {
    }

    public function index(int $article): Response
    {
        $article = $this->articleRepository->getById($article);

        $bookmarkedComments = [];
        /** @var User $user */
        if ($user = $this->authService->user()) {
            $this->reactionService->markArticle($user, $article);
            $commentsIds = $this->commentRepository->getIdsByArticle($article);
            $bookmarkedComments = $this->commentRepository->getBookmarksIds($user, $commentsIds);
        }

        return Inertia::render('Article/ArticlePage', [
            'article' => new ArticleResource($article),
            'bookmarkedComments' => $bookmarkedComments,
        ]);
    }
}

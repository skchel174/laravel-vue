<?php

declare(strict_types=1);

namespace App\Http\Controllers\Article;

use App\Http\Controllers\Controller;
use App\Http\Resources\Article\ArticleResource;
use App\Http\Resources\Comment\CommentsResource;
use App\Models\User\User;
use App\Service\ArticlesService;
use Illuminate\Contracts\Auth\StatefulGuard;
use Inertia\Inertia;
use Inertia\Response;

class ArticleController extends Controller
{
    public function __construct(
        private readonly ArticlesService $articlesService,
        private readonly StatefulGuard $authService,
    ) {
    }

    public function index(int $article): Response
    {
        $article = $this->articlesService->getById($article);

        return Inertia::render('Article/ArticlePage', [
            'article' => new ArticleResource($article),
        ]);
    }

    public function comments(int $article): Response
    {
        $article = $this->articlesService->getById($article);

        $comments = $article->comments()
            ->with('comments')
            ->paginate();

        /** @var User $user */
        if ($user = $this->authService->user()) {
            $bookmarkedComments = $user->getBookmarkedCommentsByArticle($article);
            $bookmarkedCommentsIds = $bookmarkedComments->pluck('id');
        }

        return Inertia::render('Article/CommentsPage', [
            'article' => new ArticleResource($article),
            'comments' => new CommentsResource($comments),
            'bookmarkedComments' => $bookmarkedCommentsIds ?? [],
        ]);
    }
}

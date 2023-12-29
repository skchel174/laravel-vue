<?php

declare(strict_types=1);

namespace App\Http\Controllers\Article;

use App\Http\Controllers\Controller;
use App\Http\Resources\Article\ArticleResource;
use App\Http\Resources\Comment\CommentResource;
use App\Models\Article\Article;
use App\Models\Article\Status;
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
        /** @var Article $article */
        $article = Article::query()
            ->with(['topics', 'tags'])
            ->withCount('likes', 'bookmarks', 'relatedComments')
            ->whereStatus(Status::Published)
            ->findOrFail($article);

        /** @var User $user */
        if ($user = $this->authService->user()) {
            $article->is_liked = $article->isLiked($user);
            $article->is_bookmarked = $user->isArticleBookmarked($article);
        }

        return Inertia::render('Article/ArticlePage', [
            'article' => new ArticleResource($article),
        ]);
    }

    public function comments(int $article): Response
    {
        $article = $this->articleRepository->getById($article);

        $bookmarkedComments = [];
        /** @var User $user */
        if ($user = $this->authService->user()) {
            $this->reactionService->markArticle($user, $article);
            $commentsIds = $this->commentRepository->getIdsByArticle($article);
            $bookmarkedComments = $this->commentRepository->getBookmarksIds($user, $commentsIds);
        }

        return Inertia::render('Article/CommentsPage', [
            'article' => new ArticleResource($article),
            'comments' => CommentResource::collection($article->comments),
            'bookmarkedComments' => $bookmarkedComments,
        ]);
    }
}

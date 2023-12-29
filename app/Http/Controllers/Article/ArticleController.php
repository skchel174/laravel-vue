<?php

declare(strict_types=1);

namespace App\Http\Controllers\Article;

use App\Http\Controllers\Controller;
use App\Http\Resources\Article\ArticleResource;
use App\Http\Resources\Comment\CommentsResource;
use App\Models\Article\Article;
use App\Models\Article\Status;
use App\Models\User\User;
use App\Service\MarkReactionService;
use Illuminate\Contracts\Auth\StatefulGuard;
use Inertia\Inertia;
use Inertia\Response;

class ArticleController extends Controller
{
    public function __construct(
        private readonly StatefulGuard $authService,
        private readonly MarkReactionService $reactionService,
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
            $this->reactionService->markArticle($user, $article);
        }

        return Inertia::render('Article/ArticlePage', [
            'article' => new ArticleResource($article),
        ]);
    }

    public function comments(int $article): Response
    {
        /** @var Article $article */
        $article = Article::query()
            ->with('topics')
            ->withCount('likes', 'bookmarks', 'relatedComments')
            ->whereStatus(Status::Published)
            ->findOrFail($article);

        $comments = $article->comments()
            ->with('comments')
            ->paginate();

        /** @var User $user */
        if ($user = $this->authService->user()) {
            $article->is_liked = $article->isLiked($user);
            $article->is_bookmarked = $user->isArticleBookmarked($article);

            $bookmarkedComments = $article->relatedComments()
                ->whereIn('id', $user->bookmarkedComments()->select('id'))
                ->pluck('id');
        }

        return Inertia::render('Article/CommentsPage', [
            'article' => new ArticleResource($article),
            'comments' => new CommentsResource($comments),
            'bookmarkedComments' => $bookmarkedComments ?? [],
        ]);
    }
}

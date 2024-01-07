<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\Article\ArticleResource;
use App\Http\Resources\Comment\CommentsCollection;
use App\Models\Article\Article;
use App\Models\Article\Status;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class ArticleController extends Controller
{
    public function index(int $article): Response
    {
        $article = $this->getArticleById($article);

        if ($user = Auth::user()) {
            $subscription = $user->isFollow($article->author);
        }

        return Inertia::render('Article/ArticlePage', [
            'article' => new ArticleResource($article),
            'authorSubscription' => $subscription ?? false,
        ]);
    }

    public function comments(int $article): Response
    {
        $article = $this->getArticleById($article);

        $comments = $article->comments()
            ->with('comments')
            ->paginate();

        if ($user = Auth::user()) {
            $bookmarkedComments = $user->getBookmarkedCommentsByArticle($article);
            $bookmarkedCommentsIds = $bookmarkedComments->pluck('id');
        }

        return Inertia::render('Article/CommentsPage', [
            'article' => new ArticleResource($article),
            'comments' => new CommentsCollection($comments),
            'bookmarkedComments' => $bookmarkedCommentsIds ?? [],
        ]);
    }

    private function getArticleById(int $articleId): Article
    {
        $query = Article::query();

        if (Auth::check()) {
            $query->withExists([
                'likes as is_liked' => fn(Builder $query) => $query->whereId(Auth::id()),
                'bookmarks as is_bookmarked' => fn(Builder $query) => $query->whereId(Auth::id()),
            ]);
        }

        return $query->with(['topics', 'tags'])
            ->withCount('likes', 'bookmarks', 'relatedComments')
            ->whereStatus(Status::Published)
            ->findOrFail($articleId);
    }
}

<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\Article\SaveArticleRequest;
use App\Http\Resources\Article\ArticleResource;
use App\Http\Resources\Comment\CommentsCollection;
use App\Http\Resources\Topic\TopicResource;
use App\Http\Resources\User\UserResource;
use App\Models\Article\Article;
use App\Models\Article\Difficulty;
use App\Models\Article\FeedImage;
use App\Models\Article\ArticleMedia;
use App\Models\Article\Status;
use App\Models\Topic\Topic;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
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

    public function editor(?Article $article = null): Response
    {
        return Inertia::render('Editor/EditorPage', [
            'status' => session('status'),
            'user' => new UserResource(Auth::user()),
            'difficulty' => Difficulty::cases(),
            'topics' => TopicResource::collection(Topic::all()),
            'article' => $article ? new ArticleResource($article) : null,
        ]);
    }

    public function create(SaveArticleRequest $request): RedirectResponse
    {
        /** @var Article $article */
        $article = Auth::user()->articles()->create([
            'title' => $request->title,
            'text' => $request->text,
            'summary' => $request->summary,
            'difficulty' => $request->difficulty,
            'feed_image' => $request->image ? FeedImage::create($request->image) : null,
            'status' => Status::Moderated,
        ]);

        $article->topics()->attach($request->topics);
        $article->tags()->attach($request->tags);

        if ($request->media) {
            $media = ArticleMedia::findOrFail($request->media);
            $article->media()->associate($media)->save();
        }

        return redirect()
            ->route('article.editor', ['article' => $article->id])
            ->with('status', 'Article was successfully created and sent for moderation');
    }

    public function update(SaveArticleRequest $request, Article $article): RedirectResponse
    {
        $article->fill([
            'title' => $request->title,
            'text' => $request->text,
            'summary' => $request->summary,
            'difficulty' => $request->difficulty,
            'status' => Status::Moderated,
        ]);

        if ($request->has('image')) {
            $article->feed_image = $request->image ? FeedImage::create($request->image) : null;
        }

        $article->topics()->sync($request->topics);
        $article->tags()->sync($request->tags);
        $article->save();

        return redirect()
            ->route('article.editor', ['article' => $article->id])
            ->with('status', 'Article updates have been sent for moderation');
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

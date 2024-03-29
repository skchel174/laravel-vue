<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Events\Article\ArticleModerated;
use App\Http\Requests\Article\SaveArticleRequest;
use App\Http\Requests\ArticlesRequest;
use App\Http\Resources\Article\ArticleResource;
use App\Http\Resources\Article\ArticlesResource;
use App\Http\Resources\Comment\CommentsCollection;
use App\Http\Resources\Topic\TopicResource;
use App\Http\Resources\User\UserResource;
use App\Models\Article\Article;
use App\Models\Article\Difficulty;
use App\Models\Article\FeedImage;
use App\Models\Article\ArticleMedia;
use App\Models\Article\Period;
use App\Models\Article\Status;
use App\Models\Notification;
use App\Models\Topic\Topic;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\RateLimiter;
use Inertia\Inertia;
use Inertia\Response;

class ArticleController extends Controller
{
    public function index(Request $request, int $article): Response
    {
        $article = $this->getArticleById($article);

        if ($user = Auth::user()) {
            $subscription = $user->isFollow($article->author);

            if (!$article->author->is($user)) {
                $key = sprintf(
                    'article.%d.views.%s',
                    $article->id,
                    $request->server('REMOTE_ADDR'),
                );

                if (!RateLimiter::tooManyAttempts($key, 1)) {
                    $article->increment('views');
                    RateLimiter::hit($key, 86400); // 24 hours
                }
            }
        }

        return Inertia::render('Article/ArticlePage', [
            'article' => new ArticleResource($article),
            'authorSubscription' => $subscription ?? false,
        ]);
    }

    public function articles(ArticlesRequest $request): Response
    {
        $query = Article::whereStatus(Status::Published);

        if ($user = Auth::user()) {
            $query->withExists([
                'bookmarks as is_bookmarked' => fn(Builder $query) => $query->where('id', $user->id),
            ]);
        }

        if ($request->period) {
            $query->forPeriod(Period::from($request->period));
        }

        if ($request->difficulty) {
            $query->whereDifficulty(Difficulty::from($request->difficulty));
        }

        $articles = $query
            ->withCount('relatedComments')
            ->with(['topics'])
            ->orderByDesc('id')
            ->paginate()
            ->withQueryString();

        Inertia::share('nav.location', 'articles');

        return Inertia::render('Articles/ArticlesPage', [
            'articles' => new ArticlesResource($articles),
        ]);
    }

    public function feed(): Response
    {
        $query = Article::whereStatus(Status::Published);

        if ($user = Auth::user()) {
            $query->withExists([
                'bookmarks as is_bookmarked' => fn(Builder $query) => $query->where('id', $user->id),
            ]);

            $query->whereRelation('topics', function (Builder $query) use ($user) {
                $query->whereIn('id', $user->topics()->pluck('id'));
            })->orWhereRelation('author', function (Builder $query) use ($user) {
                $query->whereIn('id', $user->followings()->pluck('id'));
            });
        }

        //TODO: query for new use without subscribes

        $articles = $query
            ->withCount('relatedComments')
            ->with(['topics'])
            ->orderByDesc('id')
            ->paginate()
            ->withQueryString();

        Inertia::share('nav.location', 'feed');

        return Inertia::render('Articles/FeedPage', [
            'articles' => new ArticlesResource($articles),
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
            'lang' => $request->lang,
            'button_text' => $request->button_text,
            'feed_image' => $request->image ? FeedImage::create($request->image) : null,
            'status' => $request->status,
        ]);

        // TODO: add tests
        $categories = Collection::make($request->topics)
            ->map(fn (Topic $topic) => $topic->category_id)
            ->unique();

        $article->categories()->attach($categories);

        $article->topics()->attach($request->topics);

        $article->tags()->attach($request->tags);

        if ($request->media) {
            $media = ArticleMedia::findOrFail($request->media);
            $article->media()->associate($media)->save();
        }

        if ($article->status->isModerated()) {
            Event::dispatch(new ArticleModerated($article));
        }

        $notification = $article->status->isModerated()
            ? trans('article.sent_for_moderation')
            : trans('article.saved_as_draft');

        return redirect()
            ->route('article.editor', ['article' => $article->id])
            ->with('notification', Notification::success($notification));
    }

    public function update(SaveArticleRequest $request, Article $article): RedirectResponse
    {
        $article->fill([
            'title' => $request->title,
            'text' => $request->text,
            'summary' => $request->summary,
            'difficulty' => $request->difficulty,
            'lang' => $request->lang,
            'button_text' => $request->button_text,
            'status' => $request->status,
        ]);

        if ($request->has('image')) {
            $article->feed_image = $request->image ? FeedImage::create($request->image) : null;
        }

        $article->save();

        $article->topics()->sync($request->topics);
        $article->tags()->sync($request->tags);

        if ($article->status->isModerated()) {
            Event::dispatch(new ArticleModerated($article));
        }

        $notification = $article->status->isModerated()
            ? trans('article.sent_for_moderation')
            : trans('article.draft_updated');

        return redirect()
            ->route('article.editor', ['article' => $article->id])
            ->with('notification', Notification::success($notification));
    }

    public function delete(Article $article): RedirectResponse
    {
        $article->delete();

        return redirect()->back()
            ->with('notification', Notification::success(trans('article.deleted')));
    }

    public function restore(Article $article): RedirectResponse
    {
        $article->restore();

        return redirect()->back()
            ->with('success', Notification::success(trans('article.restore')));
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
                'bookmarks as is_bookmarked' => fn(Builder $query) => $query->whereId(Auth::id()),
            ]);
        }

        return $query->with(['topics', 'tags'])
            ->withCount('bookmarks', 'relatedComments')
            ->whereStatus(Status::Published)
            ->findOrFail($articleId);
    }
}

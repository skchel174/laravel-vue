<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\ArticlesRequest;
use App\Http\Resources\Article\ArticlesResource;
use App\Http\Resources\Topic\TopicResource;
use App\Http\Resources\User\UsersCollection;
use App\Models\Article\Difficulty;
use App\Models\Article\Period;
use App\Models\Article\Status as ArticleStatus;
use App\Models\Topic\Topic;
use App\Models\User\Status as UserStatus;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class TopicController extends Controller
{
    public function articles(ArticlesRequest $request, Topic $topic): Response
    {
        $topic->loadCount(['articles', 'subscribers']);

        $query = $topic->articles();

        if ($user = Auth::user()) {
            $query->withExists([
                'bookmarks as is_bookmarked' => fn(Builder $query) => $query->whereId($user->id),
            ]);
        }

        if ($request->period) {
            $query->forPeriod(Period::from($request->period));
        }

        if ($request->difficulty) {
            $query->whereDifficulty(Difficulty::from($request->difficulty));
        }

        $articles = $query->with(['topics'])
            ->withCount('relatedComments')
            ->whereStatus(ArticleStatus::Published)
            ->orderByDesc('id')
            ->paginate()
            ->withQueryString();


        return Inertia::render('Topic/ArticlesPage', [
            'topic' => new TopicResource($topic),
            'articles' => new ArticlesResource($articles),
            'subscription' => $user && $topic->isSubscribed($user),
        ]);
    }

    public function authors(Request $request, Topic $topic): Response
    {
        $topic->loadCount(['articles', 'subscribers']);

        $query = User::query();

        if ($search = $request->query('search')) {
            $query
                ->where('login', 'like', "%$search%")
                ->orWhere('name', 'like', "%$search%");
        }

        $authors = $query
            ->whereRelation('articles', function (Builder $query) use ($topic) {
                $query->whereRelation('topics', function (Builder $query) use ($topic) {
                    $query->whereId($topic->id);
                })->whereStatus(ArticleStatus::Published);
            })
            ->withCount(['articles' => function (Builder $query) {
                $query->whereStatus(ArticleStatus::Published);
            }])
            ->whereStatus(UserStatus::Active)
            ->orderByDesc('articles_count')
            ->paginate()
            ->withQueryString();

        return Inertia::render('Topic/AuthorsPage', [
            'topic' => new TopicResource($topic),
            'authors' => new UsersCollection($authors),
            'subscription' => Auth::check() && $topic->isSubscribed(Auth::user()),
            'search' => $search,
        ]);
    }
}

<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\ArticlesRequest;
use App\Http\Requests\Topics\TopicsRequest;
use App\Http\Resources\Article\ArticlesResource;
use App\Http\Resources\Category\CategoryResource;
use App\Http\Resources\Topic\TopicsResource;
use App\Http\Resources\User\UsersCollection;
use App\Models\Article\Difficulty;
use App\Models\Article\Period;
use App\Models\Article\Status as ArticleStatus;
use App\Models\Category\Category;
use App\Models\User\Status as UserStatus;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class CategoryController extends Controller
{
    public function articles(ArticlesRequest $request, Category $category): Response
    {
        $query = $category->articles();

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

        Inertia::share('nav.location', $category->slug);

        return Inertia::render('Category/ArticlesPage', [
            'category' => new CategoryResource($category),
            'articles' => new ArticlesResource($articles),
        ]);
    }

    public function topics(TopicsRequest $request, Category $category): Response
    {
        $sort = $request->sort ?? 'articles_count';
        $order = $request->order ?? 'desc';

        $topics = $category->topics()
            ->withCount(['articles', 'subscribers'])
            ->with('tags')
            ->orderBy($sort, $order)
            ->paginate()
            ->withQueryString();

        $subscriptions = [];
        if ($user = Auth::user()) {
            $subscriptions = $user->topics()->pluck('id');
        }

        Inertia::share('nav.location', $category->slug);

        return Inertia::render('Category/TopicsPage', [
            'category' => new CategoryResource($category),
            'topics' => new TopicsResource($topics),
            'subscriptions' => $subscriptions,
            'order' => $order,
            'sort' => $sort,
        ]);
    }

    public function authors(Request $request, Category $category): Response
    {
        $query = User::query();

        $search = $request->query('search');

        if ($search) {
            $query
                ->where('login', 'like', "%$search%")
                ->orWhere('name', 'like', "%$search%");
        }

        $authors = $query
            ->whereRelation('articles', function (Builder $query) use ($category) {
                $query->whereRelation('categories', function (Builder $query) use ($category) {
                    $query->whereId($category->id);
                })->whereStatus(ArticleStatus::Published);
            })
            ->withCount(['articles' => function (Builder $query) {
                $query->whereStatus(ArticleStatus::Published);
            }])
            ->whereStatus(UserStatus::Active)
            ->orderByDesc('articles_count')
            ->paginate()
            ->withQueryString();

        Inertia::share('nav.location', $category->slug);

        return Inertia::render('Category/AuthorsPage', [
            'category' => new CategoryResource($category),
            'authors' => new UsersCollection($authors),
            'search' => $search,
        ]);
    }
}

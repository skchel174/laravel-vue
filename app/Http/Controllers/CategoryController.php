<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\ArticlesRequest;
use App\Http\Resources\Article\ArticlesResource;
use App\Http\Resources\Category\CategoryResource;
use App\Models\Article\Article;
use App\Models\Article\Difficulty;
use App\Models\Article\Period;
use App\Models\Article\Status;
use App\Models\Category\Category;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class CategoryController extends Controller
{
    public function articles(ArticlesRequest $request, Category $category): Response
    {
        $query = Article::whereRelation('topics', 'category_id', $category->id);

        if ($user = Auth::user()) {
            $query->withExists([
                'likes as is_liked' => fn(Builder $query) => $query->whereId($user->id),
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
            ->withCount(['likes', 'relatedComments'])
            ->whereStatus(Status::Published)
            ->orderByDesc('id')
            ->paginate()
            ->withQueryString();

        return Inertia::render('Category/Articles/ArticlesPage', [
            'category' => new CategoryResource($category),
            'articles' => new ArticlesResource($articles),
        ]);
    }
}

<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Article\Status;
use App\Models\Category\Category;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function articles(Category $category)
    {
        $query = $category->articles();

        if (Auth::check()) {
            $query->withExists([
                'likes as is_liked' => fn(Builder $query) => $query->whereId(Auth::id()),
                'bookmarks as is_bookmarked' => fn(Builder $query) => $query->whereId(Auth::id()),
            ]);
        }

        $articles = $query->with(['topics'])
            ->withCount(['likes', 'relatedComments'])
            ->whereStatus(Status::Published)
            ->orderByDesc('id')
            ->paginate();

        return true;
    }

    public function topics(Category $category)
    {
        $topics = $category->topics()
            ->withCount(['subscribers', 'articles'])
            ->get();
    }

    public function authors(Category $category)
    {
        $authors = User::query()
            ->withCount(['articles' => function (Builder $query) use ($category) {
                $query->whereRelation('topics', function (Builder $query) use ($category) {
                    $query->whereCategoryId($category->id);
                })->whereStatus(Status::Published);
            }])
            ->having('articles_count', '>', 0)
            ->get();

        return true;
    }
}

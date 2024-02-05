<?php

declare(strict_types=1);

namespace App\Http\Controllers\Articles;

use App\Http\Controllers\Controller;
use App\Http\Resources\Article\ArticlesResource;
use App\Models\Article\Article;
use App\Models\Article\Status;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class ArticlesController extends Controller
{
    public function feed(): Response
    {
        $query = Article::query();

        if ($user = Auth::user()) {
            $query->withExists([
                'likes as is_liked' => fn(Builder $query) => $query->where('id', $user->id),
                'bookmarks as is_bookmarked' => fn(Builder $query) => $query->where('id', $user->id),
            ]);

            $query->whereRelation('topics', function (Builder $query) use ($user) {
                $query->whereIn('id', $user->topics()->pluck('id'));
            })->orWhereRelation('author', function (Builder $query) use ($user) {
                $query->whereIn('id', $user->followings()->pluck('id'));
            });
        }

        $articles = $query->whereStatus(Status::Published)
            ->withCount(['likes', 'relatedComments'])
            ->with(['topics'])
            ->orderByDesc('id')
            ->paginate();

        return Inertia::render('Feed/FeedPage', [
            'articles' => new ArticlesResource($articles),
        ]);
    }
}

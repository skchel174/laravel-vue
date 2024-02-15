<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\ArticlesRequest;
use App\Http\Resources\Article\ArticlesResource;
use App\Http\Resources\Topic\TopicResource;
use App\Models\Article\Difficulty;
use App\Models\Article\Period;
use App\Models\Article\Status as ArticleStatus;
use App\Models\Topic\Topic;
use Illuminate\Database\Eloquent\Builder;
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
            ->whereStatus(ArticleStatus::Published)
            ->orderByDesc('id')
            ->paginate()
            ->withQueryString();

        return Inertia::render('Topic/Articles/ArticlesPage', [
            'topic' => new TopicResource($topic),
            'articles' => new ArticlesResource($articles),
            'subscription' => $user && $topic->isSubscribed($user),
        ]);
    }
}

<?php

declare(strict_types=1);

namespace App\Http\Middleware\User;

use App\Http\Resources\Topic\TopicResource;
use App\Models\Topic\Topic;
use App\Models\User\User;
use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ShareContribution
{
    public function handle(Request $request, Closure $next)
    {
        /** @var User $user */
        $user = $request->route('user');

        $topics = Topic::query()
            ->distinct()
            ->withCount(['articles' => fn(Builder $query) => $query->where('author_id', $user->id)])
            ->having('articles_count', '>', 0)
            ->orderBy('articles_count', 'desc')
            ->get();

        Inertia::share([
            'contribution' => TopicResource::collection($topics),
        ]);

        return $next($request);
    }
}

<?php

declare(strict_types=1);

namespace App\Http\Middleware\User;

use App\Models\User\User;
use Closure;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ShareIndicators
{
    public function handle(Request $request, Closure $next)
    {
        /** @var User $user */
        $user = $request->route('user');

        Inertia::share([
            'indicators' => [
                'articles' => $user->articles()->count(),
                'comments' => $user->comments()->count(),
                'bookmarks' => $user->bookmarks()->count(),
                'followers' => $user->followers()->count(),
                'following' => $user->followings()->count(),
            ],
        ]);

        return $next($request);
    }
}

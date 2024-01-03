<?php

declare(strict_types=1);

namespace App\Http\Middleware\User;

use App\Models\User\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class CheckSubscription
{
    public function handle(Request $request, Closure $next)
    {
        /** @var User $user */
        if ($user = $request->route('user')) {
            Inertia::share([
                'subscription' => $this->hasSubscription($user),
            ]);
        }

        return $next($request);
    }

    private function hasSubscription(User $user): bool
    {
        if (!Auth::check()) {
            return false;
        }

        if ($user->is(Auth::user())) {
            return false;
        }

        return $user->followers()
            ->whereId(Auth::id())
            ->exists();
    }
}

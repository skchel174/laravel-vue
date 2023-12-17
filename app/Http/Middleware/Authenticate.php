<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Models\User\User;
use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    public function handle($request, Closure $next, ...$guards)
    {
        $response = parent::handle($request, $next, ...$guards);

        /** @var User $user */
        if ($user = $request->user()) {
            $user->updateLastActivityTime();
        }

        return $response;
    }

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        return $request->expectsJson() ? null : route('login.form');
    }
}

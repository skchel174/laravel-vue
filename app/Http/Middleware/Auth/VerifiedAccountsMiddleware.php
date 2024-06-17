<?php

declare(strict_types=1);

namespace App\Http\Middleware\Auth;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerifiedAccountsMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::user()->status->isWait()) {
            return $next($request);
        }

        if ($request->expectsJson()) {
            abort(403, 'Your email address is not verified.');
        }

        return redirect()->guest(route('register.notice'));
    }
}

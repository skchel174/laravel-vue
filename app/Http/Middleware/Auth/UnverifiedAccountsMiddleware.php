<?php

declare(strict_types=1);

namespace App\Http\Middleware\Auth;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UnverifiedAccountsMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::user()->status->isWait()) {
            return $next($request);
        }

        return redirect()->intended();
    }
}

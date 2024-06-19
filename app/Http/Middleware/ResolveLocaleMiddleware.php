<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class ResolveLocaleMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        App::setLocale(Session::get('locale', config('app.locale')));

        return $next($request);
    }
}

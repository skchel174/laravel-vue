<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class LoginAttemptsLimiter
{
    /**
     * @throws ValidationException
     */
    public function handle(Request $request, Closure $next, int $maxAttempt = 5): Response
    {
        $key = sprintf('%s#%s', $request->email, $request->ip());

        if (RateLimiter::tooManyAttempts($key, $maxAttempt)) {
            Event::dispatch(new Lockout($request));

            throw ValidationException::withMessages([
                'email' => sprintf(
                    'Too many login attempts. Please try again in %d seconds',
                    RateLimiter::availableIn($key)
                ),
            ]);
        }

        $response = $next($request);

        Auth::check() ? RateLimiter::clear($key) : RateLimiter::hit($key);

        return $response;
    }
}

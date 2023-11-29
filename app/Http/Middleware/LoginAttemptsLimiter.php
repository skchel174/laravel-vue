<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Cache\RateLimiter;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class LoginAttemptsLimiter
{
    public function __construct(
        private readonly Dispatcher $dispatcher,
        private readonly StatefulGuard $auth,
        private readonly RateLimiter $limiter,
    ) {
    }

    /**
     * @throws ValidationException
     */
    public function handle(Request $request, Closure $next, int $maxAttempt = 5): Response
    {
        $key = sprintf('%s#%s', $request->input('email'), $request->ip());

        if ($this->limiter->tooManyAttempts($key, $maxAttempt)) {
            $this->dispatcher->dispatch(new Lockout($request));

            throw ValidationException::withMessages([
                'email' => sprintf(
                    'Too many login attempts. Please try again in %d seconds',
                    $this->limiter->availableIn($key)
                ),
            ]);
        }

        $response = $next($request);

        if ($this->auth->check()) {
            $this->limiter->clear($key);
        } else {
            $this->limiter->hit($key);
        }

        return $response;
    }
}

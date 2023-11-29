<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Models\User\User;
use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureRegistrationVerified
{
    /**
     * @throws AuthenticationException
     */
    public function handle(Request $request, Closure $next): Response
    {
        /** @var User $user */
        if (!$user = $request->user()) {
            throw new AuthenticationException();
        }

        if (!$user->status->isActive()) {
            return redirect()->route('register.prompt');
        }

        return $next($request);
    }
}

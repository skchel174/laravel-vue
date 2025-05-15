<?php

declare (strict_types=1);

namespace App\Http\Middleware;

use App\Models\User\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class EnsureAccountNotVerified
{
    public function handle(Request $request, Closure $next)
    {
        /** @var User $user */
        if (!$user = $request->user()) {
            throw new UnauthorizedHttpException('', 'Unauthenticated');
        }

        if ($user->status->isActive()) {
            return redirect()->route('profile');
        }

        return $next($request);
    }
}

<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\RedirectIfAuthenticated as IlluminateRedirectIfAuthenticated;

class RedirectIfAuthenticated extends IlluminateRedirectIfAuthenticated
{
    protected function defaultRedirectUri(): string
    {
        return route('profile');
    }
}

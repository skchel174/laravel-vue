<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use Inertia\Inertia;
use Inertia\Response;

class AuthSessionController
{
    public function index(): Response
    {
        return Inertia::render('Login/LoginPage');
    }
}

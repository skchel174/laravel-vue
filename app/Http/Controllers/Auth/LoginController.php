<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use DomainException;
use Illuminate\Http\Response;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class LoginController extends Controller
{
    public function index(): InertiaResponse
    {
        return Inertia::render('Auth/LoginPage');
    }

    public function login(LoginRequest $request): Response
    {
        $isAuthorized = auth()->attempt(
            $request->only(['email', 'password']),
            $request->boolean('remember')
        );

        if (!$isAuthorized) {
            throw new DomainException("Invalid credentials");
        }

        $request->session()->regenerate();

        return response()->noContent();
    }
}

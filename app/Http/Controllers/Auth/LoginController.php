<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use App\Service\Auth\LoginService;
use DomainException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class LoginController extends Controller
{
    public function __construct(private readonly LoginService $service)
    {
    }

    public function index(Request $request): Response
    {
        return Inertia::render('Auth/Login', [
            'status' => session('status'),
            'error' => session('error'),
        ]);
    }

    /**
     * @throws ValidationException
     */
    public function login(LoginRequest $request): RedirectResponse
    {
        try {
            $this->service->login(
                $request->email,
                $request->password,
                (bool)$request->remember
            );

            $request->session()->regenerate();
        } catch (DomainException $e) {
            return redirect()
                ->route('login.form')
                ->with('error', $e->getMessage());
        }

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    public function logout(Request $request): RedirectResponse
    {
        $this->service->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('main');
    }
}

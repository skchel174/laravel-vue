<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use App\Service\Auth\LoginService;
use DomainException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class LoginController extends Controller
{
    public function __construct(private readonly LoginService $service)
    {
    }

    public function index(): Response
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
            $this->service->login($request->email, $request->password, (bool)$request->remember);
        } catch (DomainException $e) {
            return redirect()
                ->route('login')
                ->with('error', $e->getMessage());
        }

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    public function logout(): RedirectResponse
    {
        $this->service->logout();

        return redirect()->route('main');
    }
}

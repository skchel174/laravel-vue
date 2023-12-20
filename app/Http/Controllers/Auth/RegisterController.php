<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User\Exceptions\InvalidVerificationToken;
use App\Models\User\Exceptions\VerificationTokenExpired;
use App\Providers\RouteServiceProvider;
use App\Service\Auth\RegisterService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class RegisterController extends Controller
{
    public function __construct(private readonly RegisterService $service)
    {
    }

    public function index(): Response
    {
        return Inertia::render('Auth/Register');
    }

    public function register(RegisterRequest $request): RedirectResponse
    {
        $this->service->register($request->login, $request->email, $request->password);

        return redirect()->route('register.prompt');
    }

    public function prompt(): Response
    {
        return Inertia::render('Auth/VerifyEmail', [
            'status' => session('status'),
        ]);
    }

    public function notify(): RedirectResponse
    {
        $this->service->sendVerificationEmail();

        return redirect()
            ->route('register.prompt')
            ->with('status', 'verification-link-sent');
    }

    public function verify(Request $request): RedirectResponse
    {
        try {
            $this->service->verifyRegistration($request->token);
        } catch (InvalidVerificationToken|VerificationTokenExpired $e) {
            return redirect()
                ->route('register.prompt')
                ->with('status', $e->getMessage());
        }

        return redirect(RouteServiceProvider::HOME . '?verified=1');
    }
}


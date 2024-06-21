<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Requests\Auth\SendNotificationRequest;
use App\Models\User\User;
use App\Notifications\User\ResetPassword;
use App\Services\FlashNotifier;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

readonly class ResetPasswordController
{
    public function __construct(private FlashNotifier $notifier)
    {
    }

    public function notice(): Response
    {
        return Inertia::render('ResetPassword/NoticePage');
    }

    /**
     * @throws ValidationException
     */
    public function notify(SendNotificationRequest $request): RedirectResponse
    {
        if (!$user = User::firstWhere('email', $request->email)) {
            throw ValidationException::withMessages(['email' => trans('auth.email')]);
        }

        $user->generateVerifyToken();

        $user->notify(new ResetPassword());

        $this->notifier->info(trans('passwords.sent'));

        return back();
    }

    public function form(User $user, string $token): Response
    {
        $user->checkVerifyToken($token);

        return Inertia::render('ResetPassword/ResetPasswordPage', [
            'user' => $user->id,
            'token' => $token,
        ]);
    }
}

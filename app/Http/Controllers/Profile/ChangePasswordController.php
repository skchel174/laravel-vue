<?php

declare(strict_types=1);

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\ChangePasswordRequest;
use App\Models\Notification;
use App\Models\User\Password;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ChangePasswordController extends Controller
{
    public function __invoke(ChangePasswordRequest $request): RedirectResponse
    {
        $user = Auth::user();

        $user->changePassword(Password::create($request->password));

        Auth::logout();

        Session::invalidate();

        return redirect()->route('login')
            ->with('notification', Notification::success(trans('user.password_changed')));
    }
}

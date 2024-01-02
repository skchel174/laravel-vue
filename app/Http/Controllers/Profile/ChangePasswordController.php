<?php

declare(strict_types=1);

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\ChangePasswordRequest;
use App\Models\User\Password;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ChangePasswordController extends Controller
{
    public function __invoke(ChangePasswordRequest $request): RedirectResponse
    {
        $password = Password::create($request->password);

        Auth::user()->changePassword($password);

        Session::invalidate();

        return redirect()->route('login')
            ->with('status', 'Password successfully changed');
    }
}

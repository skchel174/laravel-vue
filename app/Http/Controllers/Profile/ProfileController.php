<?php

declare(strict_types=1);

namespace App\Http\Controllers\Profile;

use App\Http\Requests\Profile\ProfileDeleteRequest;
use App\Http\Requests\Profile\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController
{
    public function index(): Response
    {
        return Inertia::render('Profile/ProfilePage', [
            'status' => session('status'),
            'error' => session('error'),
        ]);
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = Auth::user();

        $user->update([
            'login' => $request->login,
            'name' => $request->name,
            'about' => $request->about,
        ]);

        if ($request->has('avatar')) {
            $user->setAvatar($request->avatar);
        }

        return redirect()->route('profile')
            ->with('status', 'Profile successfully updated');
    }

    public function delete(ProfileDeleteRequest $request): RedirectResponse
    {
        $user = Auth::user();

        Auth::logout();

        $user->delete();

        Session::invalidate();

        Session::regenerateToken();

        return redirect()->route('main');
    }
}

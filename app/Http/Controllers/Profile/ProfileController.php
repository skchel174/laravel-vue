<?php

declare(strict_types=1);

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\ProfileDeleteRequest;
use App\Http\Requests\Profile\ProfileUpdateRequest;
use App\Models\Notification;
use App\Models\User\Avatar;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Profile/ProfilePage');
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = Auth::user();

        if ($request->has('avatar')) {
            $user->avatar = $request->avatar ? Avatar::create($request->avatar) : null;
        }

        $user->update([
            'login' => $request->login,
            'name' => $request->name,
            'about' => $request->about,
        ]);

        return redirect()->route('profile')
            ->with('notification', Notification::success(trans('user.profile_updated')));
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

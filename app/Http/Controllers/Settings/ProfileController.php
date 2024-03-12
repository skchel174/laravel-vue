<?php

declare(strict_types=1);

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\ProfileUpdateRequest;
use App\Http\Resources\User\UserContactResource;
use App\Models\Notification;
use App\Models\User\Avatar;
use App\Models\User\ContactType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{
    public function index(): Response
    {
        $user = Auth::user();

        $contacts = $user->contacts->sortBy('contact_type_id');

        return Inertia::render('Settings/Profile/ProfilePage', [
            'contactTypes' => ContactType::all(),
            'contacts' => UserContactResource::collection($contacts),
        ]);
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = Auth::user();

        if ($request->has('avatar')) {
            $user->avatar = $request->avatar
                ? Avatar::create($request->avatar)
                : null;
        }

        if ($request->contacts) {
            $user->syncContacts(Collection::make($request->contacts));
        }

        $user->update([
            'login' => $request->login,
            'name' => $request->name,
            'about' => $request->about,
            'gender' => $request->gender,
            'birthday' => $request->birthday,
        ]);

        return redirect()->route('settings.profile')
            ->with('notification', Notification::success(trans('user.profile_updated')));
    }
}

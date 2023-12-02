<?php

declare(strict_types=1);

namespace App\Http\Controllers\Profile;

use App\Http\Requests\Profile\ProfileDeleteRequest;
use App\Http\Requests\Profile\ProfileUpdateRequest;
use App\Service\Profile\ProfileService;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class ProfileController
{
    public function __construct(private readonly ProfileService $service)
    {
    }

    public function index(): Response
    {
        return Inertia::render('Profile/Edit', [
            'status' => session('status'),
            'error' => session('error'),
        ]);
    }

    /**
     * @throws FileDoesNotExist| FileIsTooBig
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $this->service->updateProfileInfo($request->user(), $request->getDto());

        return redirect()
            ->route('profile')
            ->with('status', 'Profile successfully updated');
    }

    public function delete(ProfileDeleteRequest $request): RedirectResponse
    {
        $this->service->deleteProfile($request->user());

        return redirect()->route('main');
    }
}

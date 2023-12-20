<?php

declare(strict_types=1);

namespace App\Service\Profile;

use App\Events\User\ProfileUpdated;
use App\Models\User\User;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Session\Session;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class ProfileService
{
    public function __construct(
        private readonly Dispatcher $dispatcher,
        private readonly Session $session,
        private readonly StatefulGuard $auth,
    ) {
    }

    /**
     * @throws FileIsTooBig|FileDoesNotExist
     */
    public function updateProfileInfo(ProfileUpdateDto $data): void
    {
        /** @var User $user */
        $user = $this->auth->user();

        $user->update([
            'login' => $data->login,
            'name' => $data->name,
            'about' => $data->about,
        ]);

        if ($data->avatarUpdated) {
            $user->setAvatar($data->avatar);
        }

        $this->dispatcher->dispatch(new ProfileUpdated($user));
    }

    public function deleteProfile(): void
    {
        /** @var User $user */
        $user = $this->auth->user();

        $this->auth->logout();

        $user->delete();

        $this->session->invalidate();

        $this->session->regenerateToken();
    }
}

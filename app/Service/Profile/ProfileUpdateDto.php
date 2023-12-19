<?php

declare(strict_types=1);

namespace App\Service\Profile;

use Illuminate\Http\UploadedFile;

class ProfileUpdateDto
{
    public function __construct(
        public readonly string $login,
        public readonly string $name,
        public readonly string $about,
        public readonly ?UploadedFile $avatar,
        public readonly bool $avatarUpdated,
    ) {
    }
}

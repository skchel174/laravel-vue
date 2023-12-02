<?php

declare(strict_types=1);

namespace App\Service\Profile;

use Illuminate\Http\UploadedFile;

class ProfileInfoDto
{
    public function __construct(
        public readonly string $name,
        public readonly string $about,
        public readonly ?UploadedFile $avatar,
        public readonly bool $avatarUpdated,
    ) {
    }
}

<?php

declare(strict_types=1);

namespace App\Http\Requests\Profile;

use App\Models\User\User;
use App\Service\Profile\ProfileInfoDto;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;

/**
 * @property-read string $name
 * @property-read string $about
 * @property-read UploadedFile|null $avatar
 * @method User user()
 */
class ProfileUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'string|max:60',
            'about' => 'nullable|string|max:1000',
            'avatar' => 'nullable|file|mimes:jpg,bmp,png|max:10240', // max 10MB
        ];
    }

    public function getDto(): ProfileInfoDto
    {
        return new ProfileInfoDto(
            $this->name,
            (string) $this->about,
            $this->avatar,
            $this->has('avatar'),
        );
    }
}

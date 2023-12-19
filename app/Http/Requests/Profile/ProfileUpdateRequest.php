<?php

declare(strict_types=1);

namespace App\Http\Requests\Profile;

use App\Models\User\User;
use App\Service\Profile\ProfileUpdateDto;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\Rule;

/**
 * @property-read string $login
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
            'login' => [
                'required',
                'string',
                'min:3',
                'max:25',
                'regex:/^[a-zA-Z0-9]+$/',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'regex' => 'Login can only contain letters (A-Z a-z) and numbers (0-9)',
        ];
    }

    public function getDto(): ProfileUpdateDto
    {
        return new ProfileUpdateDto(
            $this->login,
            (string) $this->name,
            (string) $this->about,
            $this->avatar,
            $this->has('avatar'),
        );
    }
}

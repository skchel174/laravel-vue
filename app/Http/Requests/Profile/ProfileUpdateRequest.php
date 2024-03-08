<?php

declare(strict_types=1);

namespace App\Http\Requests\Profile;

use App\Models\User\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\Rule;

/**
 * @property-read string $login
 * @property-read string|null $name
 * @property-read string|null $about
 * @property-read string|null $birthday
 * @property-read string|null $gender
 * @property-read UploadedFile|null $avatar
 * @method User user()
 */
class ProfileUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'nullable|string|max:60',
            'about' => 'nullable|string|max:50',
            'avatar' => 'nullable|file|mimes:jpg,bmp,png|max:1024', // max 1MB
            'birthday' => 'nullable|string|date',
            'gender' => ['nullable', 'string', Rule::in(['Male', 'Female'])],

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
}

<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property-read string $email
 * @property-read string $username
 * @property-read string $password
 */
class RegisterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => 'required|string|email|unique:users,email',
            'username' => 'required|string|min:3|max:25|regex:/^[a-zA-Z0-9]+$/|unique:users,username',
            'password' => 'required|confirmed|min:6',
        ];
    }

    public function messages(): array
    {
        return [
            'regex' => 'Username can only contain letters (A-Z a-z) and numbers (0-9)',
        ];
    }
}

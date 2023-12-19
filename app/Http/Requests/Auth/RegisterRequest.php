<?php

declare(strict_types=1);

namespace App\Http\Requests\Auth;

use App\Models\User\User;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property-read string $login
 * @property-read string $email
 * @property-read string $password
 */
class RegisterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'login' => 'required|string|min:3|max:25|regex:/^[a-zA-Z0-9]+$/|unique:' . User::class,
            'email' => 'required|string|email|unique:' . User::class,
            'password' => 'required|confirmed|min:6',
        ];
    }

    public function messages(): array
    {
        return [
            'regex' => 'Login can only contain letters (A-Z a-z) and numbers (0-9)',
        ];
    }
}

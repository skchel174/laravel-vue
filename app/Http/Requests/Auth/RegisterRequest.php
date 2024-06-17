<?php

declare(strict_types=1);

namespace App\Http\Requests\Auth;

use App\Models\User\User;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $email
 * @property string $username
 * @property string $password
 */
class RegisterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => 'required|string|email|unique:' . User::class,
            'username' => 'required|string|min:3|max:25|regex:/^[a-zA-Z0-9]+$/|unique:' . User::class . ',username',
            'password' => ['required', 'confirmed', 'min:8'],
        ];
    }

    public function messages(): array
    {
        return [
            'regex' => 'Username can only contain letters (A-Z a-z) and numbers (0-9)',
        ];
    }
}

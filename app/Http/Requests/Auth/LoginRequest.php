<?php

declare(strict_types=1);

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property-read string $email
 * @property-read string $password
 * @property-read bool $remember
 */
class LoginRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => 'required|string|exists:users,email',
            'password' => 'required|string',
        ];
    }
}

<?php

declare(strict_types=1);

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property-read string $token
 * @property-read string $password
 */
class PasswordRecoveryRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'token' => 'required|string|exists:users,verify_token',
            'password' => 'required|confirmed|min:6',
        ];
    }
}

<?php

declare(strict_types=1);

namespace App\Http\Requests\Auth;

use App\Models\User\User;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property-read string $login
 * @property-read string $password
 * @property-read bool $remember
 */
class LoginRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'login' => 'required|string|exists:' . User::class,
            'password' => 'required|string',
        ];
    }
}

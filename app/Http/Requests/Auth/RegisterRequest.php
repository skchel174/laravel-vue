<?php

declare(strict_types=1);

namespace App\Http\Requests\Auth;

use App\Models\User\User;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property-read string $name
 * @property-read string $email
 * @property-read string $password
 */
class RegisterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:60',
            'email' => 'required|string|email|unique:' . User::class,
            'password' => 'required|confirmed|min:6',
        ];
    }
}

<?php

declare(strict_types=1);

namespace App\Http\Requests\Profile;

use App\Models\User\User;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property-read string $email
 * @property-read string $password
 */
class ChangeEmailRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|current_password',
        ];
    }
}

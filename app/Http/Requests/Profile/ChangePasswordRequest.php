<?php

declare(strict_types=1);

namespace App\Http\Requests\Profile;

use App\Models\User\User;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property-read string $current_password
 * @property-read string $password
 * @method User user()
 */
class ChangePasswordRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'current_password' => 'required|string|current_password',
            'password' => 'required|min:6|confirmed',
        ];
    }
}

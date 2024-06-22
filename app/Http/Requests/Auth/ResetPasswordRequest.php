<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property-read string $password
 */
class ResetPasswordRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'password' => 'required|confirmed|min:8',
        ];
    }
}

<?php

declare(strict_types=1);

namespace App\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property-read string $password
 */
class ProfileDeleteRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'password' => 'required|current_password',
        ];
    }
}

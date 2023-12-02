<?php

declare(strict_types=1);

namespace App\Http\Requests\Profile;

use App\Models\User\User;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property-read string $password
 * @method User user()
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

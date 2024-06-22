<?php

declare(strict_types=1);

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $email
 */
class SendNotificationRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => 'required|string|email',
        ];
    }
}

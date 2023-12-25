<?php

declare(strict_types=1);

namespace App\Http\Requests\Comment;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property-read string $text
 */
class CreateCommentRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'text' => 'required|string|min:1',
        ];
    }
}

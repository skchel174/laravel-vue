<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Models\Localization\Locale;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property-read string $locale
 * @property-read array $content_langs
 */
class SetLocaleRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'locale' => ['required', 'string', Rule::enum(Locale::class)],
            'content_langs' => ['required', 'array', 'min:1', Rule::in(Locale::cases())],
        ];
    }
}

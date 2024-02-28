<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Models\Localization\Locale;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property-read string $view
 * @property-read string $locale
 * @property-read array $langs
 */
class ChangePageSettingsRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'view' => ['required', 'string', Rule::in(['classic', 'compact'])],
            'locale' => ['required', 'string', Rule::enum(Locale::class)],
            'langs' => ['required', 'array', 'min:1', Rule::in(Locale::cases())],
        ];
    }
}

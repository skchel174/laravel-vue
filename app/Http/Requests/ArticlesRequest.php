<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Models\Article\Difficulty;
use App\Models\Article\Period;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property-read string|null $period
 * @property-read string|null $difficulty
 */
class ArticlesRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'period' => ['nullable', Rule::enum(Period::class)],
            'difficulty' => ['nullable', Rule::enum(Difficulty::class)],
        ];
    }
}

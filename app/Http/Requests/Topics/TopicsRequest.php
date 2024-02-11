<?php

declare(strict_types=1);

namespace App\Http\Requests\Topics;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property-read string|null $sort
 * @property-read string|null $order
 */
class TopicsRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'sort' => ['nullable', 'string', Rule::in(['name', 'articles_count', 'subscribers_count'])],
            'order' => ['nullable', 'string', Rule::in(['asc', 'desc'])],
        ];
    }
}

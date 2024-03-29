<?php

declare(strict_types=1);

namespace App\Http\Requests\Article;

use App\Models\Article\Difficulty;
use App\Models\Article\Status;
use App\Models\Localization\Locale;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\Rule;

/**
 * @property-read string $title
 * @property-read string $text
 * @property-read string|null $summary
 * @property-read UploadedFile|null $image
 * @property-read array|null $tags
 * @property-read array $topics
 * @property-read Difficulty|null $difficulty
 * @property-read string $lang
 * @property-read string|null $button_text
 * @property-read int|null $media
 * @property-read Status|null $status
 */
class SaveArticleRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:100',
            'text' => 'required|string',
            'summary' => 'nullable|string|max:1000',
            'image' => 'nullable|file|mimes:jpg,jpeg,bmp,png|max:1024', // 1Mb
            'tags' => 'nullable|array',
            'topics' => 'required|array|min:1',
            'media' => 'nullable|integer|exists:article_media,id',
            'difficulty' => ['nullable', Rule::enum(Difficulty::class)],
            'lang' => ['required', Rule::enum(Locale::class)],
            'status' => [Rule::enum(Status::class), Rule::in([Status::Draft, Status::Moderated])],
            'button_text' => 'nullable|string|max:30',
        ];
    }
}

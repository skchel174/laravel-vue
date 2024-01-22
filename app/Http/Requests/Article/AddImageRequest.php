<?php

declare(strict_types=1);

namespace App\Http\Requests\Article;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;

/**
 * @property-read UploadedFile $image
 */
class AddImageRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'image' => 'file|mimes:jpg,jpeg,bmp,png|max:10240' // 10Mb,
        ];
    }
}

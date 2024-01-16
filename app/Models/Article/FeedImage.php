<?php

declare(strict_types=1);

namespace App\Models\Article;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use InvalidArgumentException;

class FeedImage implements CastsAttributes
{
    private string $filename;

    public static function create(UploadedFile $file): static
    {
        $image = new static();
        $image->filename = sprintf('%s.%s', Str::uuid(), $file->guessExtension());
        Storage::disk('public')->putFileAs('uploads/articles', $file, $image->filename);

        return $image;
    }

    public function getUrl(): string
    {
        return Storage::disk('public')->url('uploads/articles/' . $this->filename);
    }

    public function getFile(): string
    {
        return Storage::disk('public')->path('uploads/articles/' . $this->filename);
    }

    public function get(Model $model, string $key, mixed $value, array $attributes): ?static
    {
        if (!isset($attributes['feed_image'])) {
            return null;
        }

        $instance = new static();
        $instance->filename = $attributes['feed_image'];

        return $instance;
    }

    public function set(Model $model, string $key, mixed $value, array $attributes): array
    {
        if ($value && !$value instanceof FeedImage) {
            throw new InvalidArgumentException('The given value is not an article FeedImage instance.');
        }

        if (isset($attributes['feed_image']) && $attributes['feed_image'] !== $value?->filename) {
            Storage::disk('public')->delete('uploads/articles/' . $attributes['feed_image']);
        }

        return ['feed_image' => $value?->filename];
    }
}

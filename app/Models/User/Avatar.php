<?php

declare(strict_types=1);

namespace App\Models\User;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use InvalidArgumentException;

class Avatar implements CastsAttributes
{
    private string $filename;

    public static function create(UploadedFile $file): static
    {
        $avatar = new static();
        $avatar->filename = Str::uuid() . '.' . $file->guessExtension();
        Storage::disk('public')->putFileAs('uploads/avatars', $file, $avatar->filename);

        return $avatar;
    }

    public function getUrl(): string
    {
        return Storage::disk('public')->url('uploads/avatars/' . $this->filename);
    }

    public function getFilePath(): string
    {
        return Storage::disk('public')->path('uploads/avatars/' . $this->filename);
    }

    public function get(Model $model, string $key, mixed $value, array $attributes): ?static
    {
        if (!isset($attributes['avatar'])) {
            return null;
        }

        $instance = new static();
        $instance->filename = $attributes['avatar'];

        return $instance;
    }

    public function set(Model $model, string $key, mixed $value, array $attributes): array
    {
        if ($value && !$value instanceof Avatar) {
            throw new InvalidArgumentException('The given value is not an user Avatar instance.');
        }

        if (isset($attributes['avatar']) && $attributes['avatar'] !== $value?->filename) {
            Storage::disk('public')->delete('uploads/avatars/' . $attributes['avatar']);
        }

        return ['avatar' => $value?->filename];
    }
}

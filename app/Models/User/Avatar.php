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
    private string $image;

    public static function create(?UploadedFile $file): static
    {
        $avatar = new static();
        $avatar->image = sprintf('%s.%s', Str::uuid(), $file->guessExtension());
        Storage::disk('public')->putFileAs('uploads/avatars', $file, $avatar->image);

        return $avatar;
    }

    public function getUrl(): ?string
    {
        $path = $this->makeImageFilePath($this->image);

        return Storage::disk('public')->url($path);
    }

    public function getImagePath(): string
    {
        $path = $this->makeImageFilePath($this->image);

        return Storage::disk('public')->path($path);
    }

    public function get(Model $model, string $key, mixed $value, array $attributes): ?static
    {
        if (!$attributes['avatar']) {
            return null;
        }

        $avatar = new static();
        $avatar->image = $attributes['avatar'];

        return $avatar;
    }

    public function set(Model $model, string $key, mixed $value, array $attributes): array
    {
        if ($value && !$value instanceof Avatar) {
            throw new InvalidArgumentException(sprintf(
                'The given value is not an user %s instance.',
                static::class,
            ));
        }

        if (isset($attributes['avatar']) && $attributes['avatar'] !== $value?->image) {
            $path = $this->makeImageFilePath($attributes['avatar']);
            Storage::disk('public')->delete($path);
        }

        return ['avatar' => $value?->image];
    }

    private function makeImageFilePath(string $filename): string
    {
        return sprintf('uploads/avatars/%s', $filename);
    }
}

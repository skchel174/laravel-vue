<?php

declare(strict_types=1);

namespace App\Models\User;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use InvalidArgumentException;
use Spatie\Image\Image;

class Avatar implements CastsAttributes
{
    private ?string $file = null;

    public static function create(UploadedFile $file): static
    {
        $avatar = new static();
        $avatar->file = Str::uuid() . '.' . $file->guessExtension();

        Image::load($file->path())
            ->width(300)
            ->height(300)
            ->save($avatar->getFilePath());

        unlink($file->path());

        return $avatar;
    }

    public function getFile(): ?string
    {
        return $this->file;
    }

    public function getFilePath(): string
    {
        $conf = config('assets.avatar');

        return Storage::disk($conf['disk'])->path($conf['path'] . '/' . $this->file);
    }

    public function getUrl(): string
    {
        $conf = config('assets.avatar');

        return Storage::disk($conf['disk'])->url($conf['path'] . '/' . $this->file);
    }

    public function get(Model $model, string $key, mixed $value, array $attributes): ?static
    {
        if (!isset($attributes['avatar'])) {
            return null;
        }

        $instance = new static();
        $instance->file = $attributes['avatar'] ?? null;

        return $instance;
    }

    public function set(Model $model, string $key, mixed $value, array $attributes): array
    {
        if ($value && !$value instanceof Avatar) {
            throw new InvalidArgumentException('The given value is not an Avatar instance.');
        }

        return [
            'avatar' => $value?->file,
        ];
    }
}

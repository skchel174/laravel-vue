<?php

declare(strict_types=1);

namespace App\Models\Article;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;

enum Status: string implements CastsAttributes
{
    case Moderated = 'moderated';
    case Published = 'published';
    case Draft = 'draft';
    case Deleted = 'deleted';

    public function isPublished(): bool
    {
        return $this === Status::Published;
    }

    public function isModerated(): bool
    {
        return $this === Status::Moderated;
    }

    public function isDraft(): bool
    {
        return $this === Status::Draft;
    }

    public function isDeleted(): bool
    {
        return $this === Status::Deleted;
    }

    public function get(Model $model, string $key, mixed $value, array $attributes): Status
    {
        return Status::from($attributes['status']);
    }

    public function set(Model $model, string $key, mixed $value, array $attributes): array
    {
        if (!$value instanceof Status) {
            throw new InvalidArgumentException('The given value is not an article Status.');
        }

        return [
            'status' => $value->value,
        ];
    }
}

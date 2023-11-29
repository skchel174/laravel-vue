<?php

declare(strict_types=1);

namespace App\Models\User;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;

enum Status: string implements CastsAttributes
{
    case Wait = 'wait';
    case Active = 'active';

    public function isWait(): bool
    {
        return $this === Status::Wait;
    }

    public function isActive(): bool
    {
        return $this === Status::Active;
    }

    public function get(Model $model, string $key, mixed $value, array $attributes): Status
    {
        return Status::from($attributes['status']);
    }

    public function set(Model $model, string $key, mixed $value, array $attributes): array
    {
        if (!$value instanceof Status) {
            throw new InvalidArgumentException('The given value is not an UserStatus.');
        }

        return [
            'status' => $value->value,
        ];
    }
}

<?php

declare(strict_types=1);

namespace App\Models\User\Casts;

use App\Models\User\Email;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;
use RuntimeException;

class EmailCast implements CastsAttributes
{
    public function get(Model $model, string $key, mixed $value, array $attributes): Email
    {
        return new Email($attributes['email'], $attributes['new_email'] ?? null);
    }

    public function set(Model $model, string $key, mixed $value, array $attributes): array
    {
        if (!$value instanceof Email) {
            throw new InvalidArgumentException(sprintf(
                'The given value is not an %s.',
                Email::class
            ));
        }

        if ($model->exists && $value->getValue() !== $attributes['email']) {
            throw new RuntimeException('Email can not be changed.');
        }

        return [
            'email' => $value->getValue(),
            'new_email' => $value->getNewValue(),
        ];
    }
}

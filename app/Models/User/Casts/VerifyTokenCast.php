<?php

declare(strict_types=1);

namespace App\Models\User\Casts;

use App\Models\User\VerifyToken;
use Carbon\CarbonImmutable;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;

class VerifyTokenCast implements CastsAttributes
{
    public function get(Model $model, string $key, mixed $value, array $attributes): ?VerifyToken
    {
        if (!isset($attributes['verify_token'], $attributes['verify_token_expires_at'])) {
            return null;
        }

        return new VerifyToken(
            $attributes['verify_token'],
            new CarbonImmutable($attributes['verify_token_expires_at'])
        );
    }

    public function set(Model $model, string $key, mixed $value, array $attributes): array
    {
        if ($value && !$value instanceof VerifyToken) {
            throw new InvalidArgumentException(sprintf(
                'The given value is not an %s.',
                VerifyToken::class
            ));
        }

        return [
            'verify_token' => $value?->getValue(),
            'verify_token_expires_at' => $value?->getExpirationDate()->format('Y-m-d H:i:s'),
        ];
    }
}

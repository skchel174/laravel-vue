<?php

declare(strict_types=1);

namespace App\Models\User;

use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use InvalidArgumentException;

class VerifyToken implements CastsAttributes
{
    private string $value;
    private CarbonImmutable $timestamp;

    public static function create(): static
    {
        $token = new static();
        $token->value = Str::uuid()->toString();
        $token->timestamp = CarbonImmutable::now();

        return $token;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function isEquals(string $token): bool
    {
        return $this->value === $token;
    }

    public function isExpired(int $timeout): bool
    {
        return Carbon::now() > $this->timestamp->addSeconds($timeout);
    }

    public function get(Model $model, string $key, mixed $value, array $attributes): ?static
    {
        if (!isset($attributes['verify_token'], $attributes['verify_token_timestamp'])) {
            return null;
        }

        $token = new static();
        $token->value = $attributes['verify_token'];
        $token->timestamp = new CarbonImmutable($attributes['verify_token_timestamp']);

        return $token;
    }

    public function set(Model $model, string $key, mixed $value, array $attributes): array
    {
        if ($value && !$value instanceof VerifyToken) {
            throw new InvalidArgumentException(sprintf('The given value is not an %s.', static::class));
        }

        return [
            'verify_token' => $value?->value,
            'verify_token_timestamp' => $value?->timestamp->format('Y-m-d H:i:s'),
        ];
    }
}

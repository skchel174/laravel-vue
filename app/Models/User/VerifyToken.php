<?php

declare(strict_types=1);

namespace App\Models\User;

use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use InvalidArgumentException;

class VerifyToken
{
    private string $value;
    private CarbonImmutable $date;

    public static function create(): static
    {
        $instance = new static();
        $instance->value = Str::uuid()->toString();
        $instance->date = CarbonImmutable::now();

        return $instance;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function getDate(): CarbonImmutable
    {
        return $this->date;
    }

    public function isEquals(string $token): bool
    {
        return $this->value === $token;
    }

    public function isExpired(int $timeoutSec): bool
    {
        return Carbon::now() > $this->date->addSeconds($timeoutSec);
    }

    public function get(Model $model, string $key, mixed $value, array $attributes): ?static
    {
        if (!isset($attributes['verify_token']) || !isset($attributes['verify_token_created_at'])) {
            return null;
        }

        $instance = new static();
        $instance->value = $attributes['verify_token'];
        $instance->date = new CarbonImmutable($attributes['verify_token_created_at']);

        return $instance;
    }

    public function set(Model $model, string $key, mixed $value, array $attributes): array
    {
        if ($value && !$value instanceof VerifyToken) {
            throw new InvalidArgumentException('The given value is not an VerifyToken instance.');
        }

        return [
            'verify_token' => $value?->value,
            'verify_token_created_at' => $value?->date->format('Y-m-d H:i:s'),
        ];
    }
}

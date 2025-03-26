<?php

declare(strict_types=1);

namespace App\Models\User;

use Carbon\CarbonImmutable;
use DomainException;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

readonly class VerifyToken
{
    public function __construct(
        private string $value,
        private CarbonImmutable $expiresAt,
    )
    {
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function getExpirationDate(): CarbonImmutable
    {
        return $this->expiresAt;
    }

    public function validate(string $token, CarbonImmutable $date): void
    {
        if (!$this->isEquals($token)) {
            throw new DomainException('Verify token is invalid.');
        }

        if ($this->isExpired($date)) {
            throw new DomainException('Verify token is expired.');
        }
    }

    public function isEquals(string $token): bool
    {
        return $this->value === $token;
    }

    public function isExpired(CarbonImmutable $date): bool
    {
        return $this->expiresAt <= $date;
    }
}

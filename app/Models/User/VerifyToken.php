<?php

declare(strict_types=1);

namespace App\Models\User;

use App\Models\User\Exceptions\InvalidTokenException;
use App\Models\User\Exceptions\VerificationExpiredException;
use Carbon\CarbonImmutable;
use DomainException;
use Illuminate\Support\Str;

readonly class VerifyToken
{
    public function __construct(
        private string $value,
        private CarbonImmutable $expiresAt,
    )
    {
    }

    public static function generate(int $lifetime): self
    {
        return new self(
            Str::uuid()->toString(),
            CarbonImmutable::now()->addSeconds($lifetime)
        );
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
            throw new InvalidTokenException();
        }

        if ($this->isExpired($date)) {
            throw new VerificationExpiredException();
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

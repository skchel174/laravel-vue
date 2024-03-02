<?php

declare(strict_types=1);

namespace App\Models;

class Notification
{
    public function __construct(
        public readonly string $type,
        public readonly string $message,
    ) {
    }

    public static function success(string $message): static
    {
        return new static('success', $message);
    }

    public static function error(string $message): static
    {
        return new static('error', $message);
    }
}

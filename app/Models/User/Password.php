<?php

declare(strict_types=1);

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use InvalidArgumentException;

class Password
{
    private string $hash;

    public static function make(string $password): static
    {
        $instance = new static();
        $instance->hash = Hash::make($password);

        return $instance;
    }

    public function getHash(): string
    {
        return $this->hash;
    }

    public function isEquals(string $password): bool
    {
        return Hash::check($password, $this->hash);
    }

    public function __toString(): string
    {
        return $this->hash;
    }

    public function get(Model $model, string $key, mixed $value, array $attributes): static
    {
        $instance = new static();
        $instance->hash = $attributes['password'];

        return $instance;
    }

    public function set(Model $model, string $key, mixed $value, array $attributes): array
    {
        if (!$value instanceof Password) {
            throw new InvalidArgumentException(sprintf('The given value is not an %s.', Password::class));
        }

        return [
            'password' => $value->hash,
        ];
    }
}

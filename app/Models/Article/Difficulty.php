<?php

declare(strict_types=1);

namespace App\Models\Article;

use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;

enum Difficulty: string
{
    case Easy = 'ease';
    case Medium = 'medium';
    case Hard = 'hard';

    public function get(Model $model, string $key, mixed $value, array $attributes): Difficulty
    {
        return Difficulty::from($attributes['difficulty']);
    }

    public function set(Model $model, string $key, mixed $value, array $attributes): array
    {
        if (!$value instanceof Difficulty) {
            throw new InvalidArgumentException('The given value is not an article Difficulty');
        }

        return [
            'difficulty' => $value->value,
        ];
    }
}

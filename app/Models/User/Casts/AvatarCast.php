<?php

declare(strict_types=1);

namespace App\Models\User\Casts;

use App\Models\User\Avatar;
use App\Models\User\User;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class AvatarCast implements CastsAttributes
{
    public function get(Model $model, string $key, mixed $value, array $attributes): Avatar
    {
        /** @var User $model */
        return new Avatar($model);
    }

    public function set(Model $model, string $key, mixed $value, array $attributes): array
    {
        return [];
    }
}

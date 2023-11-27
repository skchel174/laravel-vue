<?php

declare(strict_types=1);

namespace App\Models\User;

use Carbon\CarbonImmutable;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableInterface;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\Authorizable;
/**
 * @property-read int $id
 * @property string $name
 * @property string $email
 * @property string|null $new_email
 * @property Status $status
 * @property Password $password
 * @property string $remember_token
 * @property VerifyToken $verify_token
 * @property-read CarbonImmutable $created_at
 * @property CarbonImmutable $updated_at
 * @property CarbonImmutable $login_at
 */
class User extends Model implements AuthenticatableInterface, AuthorizableInterface
{
    use HasFactory, Authenticatable, Authorizable;

    protected $fillable = [
        'name',
        'email',
        'about',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'status' => Status::class,
        'password' => Password::class,
        'verify_token' => VerifyToken::class,
        'created_at' => 'immutable_datetime:d-m-Y H:i:s',
        'updated_at' => 'immutable_datetime:d-m-Y H:i:s',
        'login_at' => 'immutable_datetime:d-m-Y H:i:s',
    ];
}

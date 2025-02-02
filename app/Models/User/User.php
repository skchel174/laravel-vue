<?php

declare(strict_types=1);

namespace App\Models\User;

use App\Models\User\Casts\EmailCast;
use App\Models\User\Casts\VerifyTokenCast;
use Carbon\CarbonImmutable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableInterface;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Notifications\Notifiable;

/**
 * @property-read int $id
 * @property string $email
 * @property string $username
 * @property string $password
 * @property Status $status
 * @property string $fullname
 * @property string $bio
 * @property string $location
 * @property Gender $gender
 * @property CarbonImmutable|null $birth_date
 * @property string|null $verify_token
 * @property CarbonImmutable $created_at
 * @property CarbonImmutable $updated_at
 */
class User extends Model implements AuthenticatableInterface, AuthorizableInterface
{
    use HasFactory, Authenticatable, Authorizable, Notifiable;

    protected $fillable = [
        'email',
        'username',
        'fullname',
        'password',
        'verify_token',
        'status',
        'bio',
        'location',
        'gender',
        'birth_date',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'verify_token',
    ];

    protected function casts(): array
    {
        return [
            'status' => Status::class,
            'gender' => Gender::class,
            'email' => EmailCast::class,
            'verify_token' => VerifyTokenCast::class,
            'password' => 'hashed',
            'birth_date' => 'immutable_datetime',
            'created_at' => 'immutable_datetime',
            'updated_at' => 'immutable_datetime',
        ];
    }
}

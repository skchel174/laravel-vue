<?php

declare(strict_types=1);

namespace App\Models\User;

use App\Models\User\Casts\AvatarCast;
use App\Models\User\Casts\EmailCast;
use App\Models\User\Casts\VerifyTokenCast;
use Carbon\CarbonImmutable;
use Database\Factories\User\UserFactory;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableInterface;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

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
 * @property Avatar $avatar
 * @property VerifyToken|null $verify_token
 * @property CarbonImmutable|null $birth_date
 * @property CarbonImmutable $created_at
 * @property CarbonImmutable $updated_at
 *
 * @method static UserFactory factory(?int $count = null, array $state = [])
 */
class User extends Model implements AuthenticatableInterface, AuthorizableInterface, HasMedia
{
    use HasFactory, Authenticatable, Authorizable, Notifiable, InteractsWithMedia;

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

    public function registerMediaCollections(): void
    {
        $this->avatar->register();
    }

    protected function casts(): array
    {
        return [
            'status' => Status::class,
            'gender' => Gender::class,
            'email' => EmailCast::class,
            'avatar' => AvatarCast::class,
            'verify_token' => VerifyTokenCast::class,
            'password' => 'hashed',
            'birth_date' => 'immutable_datetime',
            'created_at' => 'immutable_datetime',
            'updated_at' => 'immutable_datetime',
        ];
    }
}

<?php

declare(strict_types=1);

namespace App\Models\User;

use App\Models\User\Exceptions\AccountVerifiedException;
use App\Models\User\Exceptions\InvalidVerifyTokenException;
use App\Models\User\Exceptions\VerificationNotRequestedException;
use App\Models\User\Exceptions\VerificationTokenExpiredException;
use Database\Factories\User\UserFactory;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Notifications\Notifiable;

/**
 * @property-read int $id
 * @property string $email
 * @property string $username
 * @property Password $password
 * @property Status $status
 * @property-read VerifyToken|null $verifyToken
 *
 * @method static UserFactory factory($count = null, $state = [])
 * @method static User|null firstWhere(string $string, string $email)
 */
class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use HasFactory, Authenticatable, Authorizable, Notifiable;

    protected $fillable = [
        'email',
        'username',
        'password',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public static function register(string $email, string $username, string $password): static
    {
        $user = static::create([
            'email' => $email,
            'username' => $username,
            'password' => Password::make($password),
            'status' => Status::Wait,
        ]);

        $user->generateVerifyToken();

        return $user;
    }

    public function verify(string $token): void
    {
        if ($this->status->isActive()) {
            throw new AccountVerifiedException();
        }

        $this->checkVerifyToken($token);

        $this->update(['status' => Status::Active]);

        $this->verifyToken->delete();

        unset($this->verifyToken);
    }

    /**
     * Need for AuthenticateSession middleware
     */
    public function getAuthPassword(): string
    {
        return $this->password->getHash();
    }

    public function verifyToken(): HasOne
    {
        return $this->hasOne(VerifyToken::class);
    }

    public function generateVerifyToken(): void
    {
        $this->verifyToken()->save(VerifyToken::generate());
    }

    public function checkVerifyToken(string $token): void
    {
        if (!$this->verifyToken) {
            throw new VerificationNotRequestedException();
        }

        if (!$this->verifyToken->isEquals($token)) {
            throw new InvalidVerifyTokenException();
        }

        if ($this->verifyToken->isExpired(config('auth.verification_timeout'))) {
            throw new VerificationTokenExpiredException();
        }
    }

    protected function casts(): array
    {
        return [
            'status' => Status::class,
            'password' => Password::class,
            'created_at' => 'immutable_datetime',
            'updated_at' => 'immutable_datetime',
        ];
    }
}

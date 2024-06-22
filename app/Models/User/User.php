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
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

/**
 * @property-read int $id
 * @property string $email
 * @property string $username
 * @property string $password
 * @property Status $status
 * @property-read VerifyToken|null $verify_token
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
        'verify_token',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public static function register(string $email, string $username, string $password): static
    {
        return static::create([
            'email' => $email,
            'username' => $username,
            'password' => Hash::make($password),
            'status' => Status::Wait,
            'verify_token' => VerifyToken::create(),
        ]);
    }

    public function verify(string $token): void
    {
        if ($this->status->isActive()) {
            throw new AccountVerifiedException();
        }

        $this->checkVerifyToken($token);

        $this->update([
            'status' => Status::Active,
            'verify_token' => null,
        ]);
    }

    public function checkPassword(string $password): bool
    {
        return Hash::check($password, $this->password);
    }

    public function resetPassword(string $password, string $token): void
    {
        $this->checkVerifyToken($token);

        $this->update([
            'password' => Hash::make($password),
            'verify_token' => null,
        ]);
    }

    public function checkVerifyToken(string $token): void
    {
        if (!$this->verify_token) {
            throw new VerificationNotRequestedException();
        }

        if (!$this->verify_token->isEquals($token)) {
            throw new InvalidVerifyTokenException();
        }

        if ($this->verify_token->isExpired(config('auth.verification_timeout'))) {
            throw new VerificationTokenExpiredException();
        }
    }

    protected function casts(): array
    {
        return [
            'status' => Status::class,
            'verify_token' => VerifyToken::class,
            'created_at' => 'immutable_datetime',
            'updated_at' => 'immutable_datetime',
        ];
    }
}

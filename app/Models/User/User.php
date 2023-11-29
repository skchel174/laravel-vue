<?php

declare(strict_types=1);

namespace App\Models\User;

use App\Models\User\Exceptions\InvalidVerificationToken;
use App\Models\User\Exceptions\PasswordResetNotRequested;
use App\Models\User\Exceptions\RegistrationAlreadyVerified;
use App\Models\User\Exceptions\VerificationNotRequested;
use App\Models\User\Exceptions\VerificationTokenExpired;
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
        'status',
        'password',
        'new_email',
        'verify_token',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'verify_token',
    ];

    protected $casts = [
        'status' => Status::class,
        'password' => Password::class,
        'verify_token' => VerifyToken::class,
        'created_at' => 'immutable_datetime:d-m-Y H:i:s',
        'updated_at' => 'immutable_datetime:d-m-Y H:i:s',
        'login_at' => 'immutable_datetime:d-m-Y H:i:s',
    ];

    public static function register(string $name, string $email, Password $password): static
    {
        return static::create([
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'status' => Status::Wait,
            'verify_token' => VerifyToken::create(),
        ]);
    }

    public function verifyRegistration(string $token): void
    {
        if ($this->status->isActive()) {
            throw new RegistrationAlreadyVerified();
        }

        if (!$this->verify_token) {
            throw new VerificationNotRequested();
        }

        if (!$this->verify_token->isEquals($token)) {
            throw new InvalidVerificationToken();
        }

        $timeout = config('auth.verification_timeout');

        if ($this->verify_token->isExpired($timeout)) {
            throw new VerificationTokenExpired();
        }

        $this->update([
            'verify_token' => null,
            'status' => Status::Active,
        ]);
    }

    public function changeEmail(string $email): void
    {
        $this->update([
            'new_email' => $email,
            'verify_token' => VerifyToken::create(),
        ]);
    }

    public function verifyNewEmail(string $token): void
    {
        if (!$this->verify_token) {
            throw new VerificationNotRequested();
        }

        if (!$this->verify_token->isEquals($token)) {
            throw new InvalidVerificationToken();
        }

        $timeout = config('auth.verification_timeout');

        if ($this->verify_token->isExpired($timeout)) {
            throw new VerificationTokenExpired();
        }

        $this->update([
            'email' => $this->new_email,
            'new_email' => null,
            'verify_token' => null,
        ]);
    }

    public function requestVerification(): void
    {
        $this->update([
            'verify_token' => VerifyToken::create(),
        ]);
    }

    public function resetPassword(Password $password): void
    {
        if (!$this->verify_token) {
            throw new PasswordResetNotRequested();
        }

        $timeout = config('auth.password_timeout');

        if ($this->verify_token->isExpired($timeout)) {
            throw new VerificationTokenExpired();
        }

        $this->update([
            'password' => $password,
            'verify_token' => null,
        ]);
    }
}

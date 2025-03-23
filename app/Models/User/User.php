<?php

declare(strict_types=1);

namespace App\Models\User;

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
use Illuminate\Http\UploadedFile;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

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

    public function getAvatar(): ?Media
    {
        return $this->getFirstMedia('avatar');
    }

    /**
     * @throws FileIsTooBig | FileDoesNotExist
     */
    public function setAvatar(UploadedFile $file): void
    {
        $this->addMedia($file)
            ->usingFileName(Str::uuid() . '.' . $file->guessExtension())
            ->toMediaCollection('avatar');
    }

    public function deleteAvatar(): void
    {
        $this->clearMediaCollection('avatar');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('avatar')
            ->singleFile()
            ->withResponsiveImages()
            ->registerMediaConversions(function () {
                $this->addMediaConversion('md')
                    ->width(250)
                    ->height(250)
                    ->fit(Fit::Contain);

                $this->addMediaConversion('xs')
                    ->width(100)
                    ->height(100)
                    ->fit(Fit::Contain);
            });
    }

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

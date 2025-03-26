<?php

declare(strict_types=1);

namespace App\Models\User;

use Gravatar\Gravatar;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Avatar
{
    private const MEDIA_COLLECTION = 'avatar';
    private const GRAVATAR_TYPE = 'identicon';

    public function __construct(private readonly User $user)
    {
    }

    public function getPlaceholder(): string
    {
        $email = $this->user->email->getValue();
        $gravatar = Gravatar::image($email)
            ->d(self::GRAVATAR_TYPE)
            ->url();

        return sprintf('https:%s', $gravatar);
    }

    public function getImage(): ?Media
    {
        return $this->user->getFirstMedia(self::MEDIA_COLLECTION);
    }

    public function hasImage(): bool
    {
        return $this->getImage() !== null;
    }

    /**
     * @throws FileDoesNotExist|FileIsTooBig
     */
    public function setImage(?UploadedFile $image): void
    {
        $this->user->addMedia($image)
            ->usingFileName(sprintf('%s.%s', Str::uuid(), $image->guessExtension()))
            ->toMediaCollection(self::MEDIA_COLLECTION);
    }

    public function deleteImage(): void
    {
        $this->user->clearMediaCollection(self::MEDIA_COLLECTION);
    }

    public function register(): void
    {
        $this->user->addMediaCollection(self::MEDIA_COLLECTION)
            ->singleFile()
            ->withResponsiveImages()
            ->registerMediaConversions(function () {
                $this->user->addMediaConversion('md')
                    ->width(250)
                    ->height(250)
                    ->fit(Fit::Contain);

                $this->user->addMediaConversion('xs')
                    ->width(100)
                    ->height(100)
                    ->fit(Fit::Contain);
            });
    }
}

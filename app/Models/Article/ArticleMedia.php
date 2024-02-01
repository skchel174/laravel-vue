<?php

declare(strict_types=1);

namespace App\Models\Article;

use App\Models\User\User;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Spatie\Image\Exceptions\InvalidManipulation;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * @property-read int $id
 * @property-read int $author_id
 * @property-read User $author
 * @property-read Collection<Media> $media
 * @property-read Article|null $article
 * @property-read CarbonImmutable $created_at
 * @property-read CarbonImmutable $updated_at
 */
class ArticleMedia extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $casts = [
        'created_at' => 'immutable_datetime:d-m-Y H:i',
        'updated_at' => 'immutable_datetime:d-m-Y H:i',
    ];

    public static function createNew(User $author): static
    {
        $stub = new static();
        $stub->author()->associate($author);
        $stub->save();

        return $stub;
    }

    public function getImages(): Collection
    {
        return $this->getMedia('images');
    }

    /**
     * @throws FileIsTooBig|FileDoesNotExist
     */
    public function addImage(UploadedFile $file): Media
    {
        return $this->addMedia($file)
            ->usingFileName(Str::uuid() . '.' . $file->guessExtension())
            ->toMediaCollection('images');
    }

    /**
     * @throws InvalidManipulation
     */
    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('md')
            ->width(1200)
            ->height(600)
            ->nonQueued();
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function article(): HasOne
    {
        return $this->hasOne(Article::class, 'article_media_id');
    }
}

<?php

declare(strict_types=1);

namespace App\Models\Article;

use App\Models\Article\Exceptions\ArticleAlreadyLiked;
use App\Models\Article\Exceptions\ArticleModerated;
use App\Models\Article\Exceptions\ArticleNotDeleted;
use App\Models\Article\Exceptions\ArticleNotLiked;
use App\Models\Article\Exceptions\ArticlePublished;
use App\Models\Article\Exceptions\ArticleWasNotModerated;
use App\Models\Category\Category;
use App\Models\Comment\Comment;
use App\Models\Tag\Tag;
use App\Models\Topic\Topic;
use App\Models\User\User;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Spatie\Image\Exceptions\InvalidManipulation;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Throwable;

/**
 * @property-read int $id
 * @property int $user_id
 * @property string $title
 * @property string $text
 * @property Status $status
 * @property string|null $summary
 * @property Difficulty|null $difficulty
 * @property int $views
 * @property User $author
 * @property-read Collection<Media> $cardImage
 * @property-read Collection<Tag> $tags
 * @property-read Collection<Topic> $topics
 * @property-read Collection<Category> $categories
 * @property-read Collection<Comment> $comments
 * @property-read int $comments_count
 * @property-read int $likes_count
 * @property CarbonImmutable|null $published_at
 * @property-read CarbonImmutable $created_at
 * @property-read CarbonImmutable $updated_at
 */
class Article extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, SoftDeletes;

    public bool $is_liked = false;
    public bool $is_bookmarked = false;

    protected $fillable = ['title', 'text', 'summary', 'status', 'difficulty', 'views', 'published_at'];

    protected $casts = [
        'status' => Status::class,
        'difficulty' => Difficulty::class,
        'created_at' => 'immutable_datetime:d-m-Y H:i',
        'updated_at' => 'immutable_datetime:d-m-Y H:i',
        'published_at' => 'immutable_datetime:d-m-Y H:i',
    ];

    protected $with = ['author'];

    public static function createNew(
        User $author,
        string $title,
        string $text,
        ?string $summary = null,
        ?Difficulty $difficulty = null,
    ): static
    {
        $article = static::make([
            'title' => $title,
            'text' => $text,
            'summary' => $summary,
            'status' => Status::Draft,
            'difficulty' => $difficulty,
        ]);
        $article->author()->associate($author);
        $article->save();

        return $article;
    }

    public function moderate(): void
    {
        if ($this->status->isModerated()) {
            throw new ArticleModerated();
        }

        $this->update(['status' => Status::Moderated]);
    }

    /**
     * @throws Throwable
     */
    public function publish(): void
    {
        if ($this->status->isPublished()) {
            throw new ArticlePublished();
        }

        if (!$this->status->isModerated()) {
            throw new ArticleWasNotModerated();
        }

        $this->update([
            'status' => Status::Published,
            'published_at' => CarbonImmutable::now(),
        ]);
    }

    public function isLiked(User $user): bool
    {
        return $this->likes()
            ->where('id', $user->id)
            ->exists();
    }

    public function addLike(User $user): void
    {
        if ($this->isLiked($user)) {
            throw new ArticleAlreadyLiked();
        }

        $this->likes()->attach($user);
    }

    public function removeLike(User $user): void
    {
        if (!$this->isLiked($user)) {
            throw new ArticleNotLiked();
        }

        $this->likes()->detach($user);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function topics(): BelongsToMany
    {
        return $this->belongsToMany(Topic::class);
    }

    public function categories(): HasManyThrough
    {
        return $this->hasManyThrough(Category::class, Topic::class);
    }

    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function allComments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function usersBookmarked(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'bookmarked_articles');
    }

    public function likes(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'liked_articles');
    }

    public function cardImage(): MorphMany
    {
        return $this->media()->where('collection_name', 'card_image');
    }

    public function getCardImage(): ?Media
    {
        /** @var Media|null $image */
        $image = $this->cardImage->first();
        return $image;
    }

    /**
     * @throws FileIsTooBig|FileDoesNotExist
     */
    public function setCardImage(?UploadedFile $file): void
    {
        $this->media()
            ->where('collection_name', 'card_image')
            ->delete();

        if (!$file) {
            return;
        }

        $fileName = sprintf('%s.%s', Str::uuid(), $file->getExtension());

        $this->addMedia($file)
            ->usingFileName($fileName)
            ->toMediaCollection('card_image');
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

    public function remove(): void
    {
        if ($this->status->isDraft() || $this->trashed()) {
            $this->forceDelete();
            return;
        }

        $this->update(['status' => Status::Deleted]);
        $this->delete();
    }

    public function recover(): void
    {
        if (!$this->status->isDeleted()) {
            throw new ArticleNotDeleted();
        }

        $this->moderate();
        $this->restore();
    }
}

<?php

declare(strict_types=1);

namespace App\Models\Article;

use App\Events\Article\ArticleModerated;
use App\Exceptions\Article\ArticleAlreadyLiked;
use App\Exceptions\Article\ArticleAlreadyModerated;
use App\Exceptions\Article\ArticleNotDeleted;
use App\Exceptions\Article\ArticleNotLiked;
use App\Exceptions\Article\ArticlePublished;
use App\Exceptions\Article\ArticleWasNotModerated;
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
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Event;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Throwable;

/**
 * @property-read int $id
 * @property-read int $author_id
 * @property-read int $article_media_id
 * @property string $title
 * @property string $text
 * @property Status $status
 * @property string|null $summary
 * @property FeedImage|null $feed_image
 * @property Difficulty|null $difficulty
 * @property string $lang
 * @property string|null $button_text
 * @property int $views
 * @property User $author
 * @property-read Collection<Tag> $tags
 * @property-read Collection<Topic> $topics
 * @property-read Collection<Category> $categories
 * @property-read Collection<Comment> $comments
 * @property-read Collection<Media> $cardImage
 * @property-read ArticleMedia|null $media
 * @property-read int|null $comments_count
 * @property-read int|null $related_comments_count
 * @property-read bool|null $is_liked
 * @property-read int|null $likes_count
 * @property-read bool|null $is_bookmarked
 * @property CarbonImmutable|null $published_at
 * @property-read CarbonImmutable $created_at
 * @property-read CarbonImmutable $updated_at
 */
class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'text',
        'summary',
        'status',
        'difficulty',
        'lang',
        'views',
        'button_text',
        'feed_image',
        'published_at',
    ];

    protected $casts = [
        'status' => Status::class,
        'feed_image' => FeedImage::class,
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
        ?FeedImage $image = null,
    ): static
    {
        $article = static::make([
            'title' => $title,
            'text' => $text,
            'summary' => $summary,
            'difficulty' => $difficulty,
            'image' => $image,
            'status' => Status::Draft,
        ]);
        $article->author()->associate($author);
        $article->save();

        return $article;
    }

    public function moderate(): void
    {
        if ($this->status->isModerated()) {
            throw new ArticleAlreadyModerated();
        }

        $this->update(['status' => Status::Moderated]);

        Event::dispatch(new ArticleModerated($this));
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

    public function restore(): void
    {
        if (!$this->status->isDeleted()) {
            throw new ArticleNotDeleted();
        }

        $this->moderate();
    }

    public function delete(): bool
    {
        if (!$this->status->isDeleted() && !$this->status->isDraft()) {
            return $this->update([
                'published_at' => null,
                'status' => Status::Deleted,
            ]);
        }

        if ($this->media) {
            $this->media->delete();
        }

        return parent::delete();
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

    public function relatedComments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function bookmarks(): MorphToMany
    {
        return $this->morphToMany(User::class, 'bookmark', 'bookmarks');
    }

    public function likes(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'liked_articles');
    }

    public function media(): BelongsTo
    {
        return $this->belongsTo(ArticleMedia::class, 'article_media_id');
    }
}

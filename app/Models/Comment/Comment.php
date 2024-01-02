<?php

declare(strict_types=1);

namespace App\Models\Comment;

use App\Events\Comment\CommentCreated;
use App\Events\Comment\CommentUpdated;
use App\Models\Article\Article;
use App\Models\Article\Exceptions\ArticleNotPublished;
use App\Models\Comment\Exception\CommentNotCommentable;
use App\Models\Comment\Exception\ExceededEditingTimeLimit;
use App\Models\User\Exceptions\AccountNotActive;
use App\Models\User\User;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Event;

/**
 * @property-read int $id
 * @property string $text
 * @property User $author
 * @property int $depth
 * @property-read int $article_id
 * @property-read Article $article
 * @property-read bool $is_bookmarked
 * @property-read Article|Comment $commentable
 * @property-read Collection<Comment> $comments
 * @property-read CarbonImmutable $created_at
 * @property-read CarbonImmutable $updated_at
 */
class Comment extends Model
{
    use HasFactory;

    public const MAX_DEPTH = 1;

    protected $fillable = ['text', 'depth'];

    protected $with = ['author'];

    protected $casts = [
        'created_at' => 'immutable_datetime:d-m-Y H:i:s',
        'updated_at' => 'immutable_datetime:d-m-Y H:i:s',
    ];

    public static function createForArticle(Article $article, User $author, string $text): static
    {
        if (!$article->status->isPublished()) {
            throw new ArticleNotPublished();
        }

        if (!$author->status->isActive()) {
            throw new AccountNotActive();
        }

        $comment = static::make(['text' => $text]);
        $comment->author()->associate($author);
        $comment->article()->associate($article);
        $comment->commentable()->associate($article);
        $comment->save();

        Event::dispatch(new CommentCreated($comment));

        return $comment;
    }

    public static function createForComment(Comment $comment, User $author, string $text): static
    {
        if (!$comment->isCommentable()) {
            throw new CommentNotCommentable();
        }

        if (!$author->status->isActive()) {
            throw new AccountNotActive();
        }

        $article = $comment->article;

        if (!$article->status->isPublished()) {
            throw new ArticleNotPublished();
        }

        $instance = static::make([
            'text' => $text,
            'depth' => $comment->depth + 1,
        ]);

        $instance->author()->associate($author);
        $instance->article()->associate($article);
        $instance->commentable()->associate($comment);
        $instance->save();

        Event::dispatch(new CommentCreated($comment));

        return $instance;
    }

    public function getCommentsCount(): int
    {
        /** @var int $count */
        $count = $this->comments->reduce(function (int $cnt, Comment $comment) {
            return 1 + $comment->getCommentsCount();
        }, 0);

        return $count;
    }

    public function edit(string $text): void
    {
        if (!$this->isEditable(CarbonImmutable::now())) {
            throw new ExceededEditingTimeLimit();
        }

        $this->update(['text' => $text]);

        Event::dispatch(new CommentUpdated($this));
    }

    public function isAuthor(User $author): bool
    {
        return $this->author->is($author);
    }

    public function isEditable(CarbonImmutable $now): bool
    {
       return $this->created_at->diffInDays($now) < 31;
    }

    public function isCommentable(): bool
    {
        return $this->depth < static::MAX_DEPTH;
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }

    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }

    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function bookmarks(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'bookmarked_comments');
    }
}

<?php

declare(strict_types=1);

namespace App\Models\Comment;

use App\Models\Article\Article;
use App\Models\Article\Exceptions\ArticleNotPublished;
use App\Models\Comment\Exception\ExceededEditingTimeLimit;
use App\Models\Comment\Exception\NotBelongsToArticle;
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

/**
 * @property-read int $id
 * @property string $text
 * @property User $author
 * @property-read int $article_id
 * @property-read Article $article
 * @property-read Article|Comment $commentable
 * @property-read Collection<Comment> $comments
 * @property-read CarbonImmutable $created_at
 * @property-read CarbonImmutable $updated_at
 */
class Comment extends Model
{
    use HasFactory;

    public bool $is_bookmarked = false;

    protected $fillable = ['text'];

    protected $with = ['author'];

    protected $casts = [
        'created_at' => 'immutable_datetime:d-m-Y H:i:s',
        'updated_at' => 'immutable_datetime:d-m-Y H:i:s',
    ];

    private array $commentsIds = [];

    public static function createForArticle(Article $commentable, User $author, string $text): static
    {
        if (!$commentable->status->isPublished()) {
            throw new ArticleNotPublished();
        }

        if (!$author->status->isActive()) {
            throw new AccountNotActive();
        }

        $comment = new static();
        $comment->text = $text;
        $comment->author()->associate($author);
        $comment->article()->associate($commentable);
        $comment->commentable()->associate($commentable);
        $comment->save();

        return $comment;
    }

    public static function createForComment(Comment $commentable, Article $article, User $author, string $text): static
    {
        if (!$article->status->isPublished()) {
            throw new ArticleNotPublished();
        }

        if (!$author->status->isActive()) {
            throw new AccountNotActive();
        }

        if (!$commentable->belongsToArticle($article)) {
            throw new NotBelongsToArticle();
        }

        $comment = new static();
        $comment->text = $text;
        $comment->author()->associate($author);
        $comment->article()->associate($article);
        $comment->commentable()->associate($commentable);
        $comment->save();

        return $comment;
    }

    public function getCommentsCount(): int
    {
        return count($this->getCommentsIds());
    }

    public function getCommentsIds(): array
    {
        if (!$this->commentsIds) {
            $this->commentsIds = $this->comments->reduce(function (array $ids, Comment $comment) {
                return array_merge($ids, [$comment->id], $comment->getCommentsIds());
            }, []);
        }

        return $this->commentsIds;
    }

    public function edit(string $text): void
    {
        if (!$this->isEditable(CarbonImmutable::now())) {
            throw new ExceededEditingTimeLimit();
        }

        $this->update(['text' => $text]);
    }

    public function belongsToArticle(Article $article): bool
    {
        return $this->article_id === $article->id;
    }

    public function isAuthor(User $author): bool
    {
        return $this->author->is($author);
    }

    public function isEditable(CarbonImmutable $now): bool
    {
       return $this->created_at->diffInDays($now) < 31;
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

    public function usersBookmarked(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'bookmarked_comments');
    }
}

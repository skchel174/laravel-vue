<?php

declare(strict_types=1);

namespace App\Models\Comment;

use App\Models\Article\Article;
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
 * @property-read Article $article
 * @property-read Article|Comment $commentable
 * @property-read Collection<Comment> $comments
 * @property-read CarbonImmutable $created_at
 * @property-read CarbonImmutable $updated_at
 */
class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['text'];

    protected $with = ['author', 'comments'];

    private array $commentsIds = [];

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

<?php

declare(strict_types=1);

namespace App\Models\User;

use App\Events\User\EmailChanged;
use App\Events\User\EmailChanging;
use App\Events\User\PasswordChanged;
use App\Events\User\PasswordReset;
use App\Events\User\UserRegistered;
use App\Models\Article\Article;
use App\Models\Article\Exceptions\ArticleNotPublished;
use App\Models\Comment\Comment;
use App\Models\Topic\Topic;
use App\Models\User\Exceptions\BookmarkAlreadyCreated;
use App\Models\User\Exceptions\BookmarkNotCreated;
use App\Models\User\Exceptions\InvalidVerificationToken;
use App\Models\User\Exceptions\PasswordResetNotRequested;
use App\Models\User\Exceptions\RegistrationAlreadyVerified;
use App\Models\User\Exceptions\VerificationNotRequested;
use App\Models\User\Exceptions\VerificationTokenExpired;
use Carbon\CarbonImmutable;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableInterface;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * @property-read int $id
 * @property string $login
 * @property string $email
 * @property string|null $name
 * @property string|null $about
 * @property string|null $new_email
 * @property Status $status
 * @property Password $password
 * @property string $avatar_mask
 * @property string $remember_token
 * @property VerifyToken $verify_token
 * @property-read CarbonImmutable $created_at
 * @property CarbonImmutable $updated_at
 * @property CarbonImmutable $login_at
 * @property-read Collection<Article> $articles
 * @property-read Collection<Article> $bookmarkedArticles
 * @property-read Collection<Article> $likedArticles
 * @property-read Collection<Topic> $topics
 *
 * @method static Builder whereLogin(string $login)
 * @method static Builder whereEmail(string $email)
 * @method static Builder whereVerifyToken(string $token)
 */
class User extends Model implements AuthenticatableInterface, AuthorizableInterface, HasMedia
{
    use HasFactory, Authenticatable, Authorizable, InteractsWithMedia;

    protected $fillable = [
        'login', 'email', 'name', 'about', 'status', 'password', 'new_email', 'avatar_mask', 'verify_token',
    ];

    protected $hidden = [
        'password', 'remember_token', 'verify_token',
    ];

    protected $casts = [
        'status' => Status::class,
        'password' => Password::class,
        'verify_token' => VerifyToken::class,
        'created_at' => 'immutable_datetime:d-m-Y H:i:s',
        'updated_at' => 'immutable_datetime:d-m-Y H:i:s',
        'login_at' => 'immutable_datetime:d-m-Y H:i:s',
    ];

    public static function register(string $login, string $email, Password $password, string $avatar): static
    {
        $user = static::create([
            'login' => $login,
            'email' => $email,
            'password' => $password,
            'avatar_mask' => $avatar,
            'status' => Status::Wait,
            'verify_token' => VerifyToken::create(),
        ]);

        Event::dispatch(new UserRegistered($user));

        return $user;
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

        Event::dispatch(new EmailChanging($this));
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

        Event::dispatch(new EmailChanged($this));
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

        Event::dispatch(new PasswordReset($this));
    }

    public function changePassword(Password $password): void
    {
        $this->update(['password' => $password]);

        Event::dispatch(new PasswordChanged($this));
    }

    public function isArticleBookmarked(Article $article): bool
    {
        return $this->bookmarkedArticles()
            ->where('id', $article->id)
            ->exists();
    }

    public function makeArticleBookmark(Article $article)
    {
        if (!$article->status->isPublished()) {
            throw new ArticleNotPublished();
        }

        if ($this->isArticleBookmarked($article)) {
            throw new BookmarkAlreadyCreated();
        }

        $this->bookmarkedArticles()->attach($article);
    }

    public function removeArticleBookmark(Article $article): void
    {
        if (!$this->isArticleBookmarked($article)) {
            throw new BookmarkNotCreated();
        }

        $this->bookmarkedArticles()->detach($article);
    }

    public function makeCommentBookmark(Comment $comment)
    {
        if ($this->isCommentBookmarked($comment)) {
            throw new BookmarkAlreadyCreated();
        }

        $this->bookmarkedComments()->attach($comment);
    }

    public function removeCommentBookmark(Comment $comment): void
    {
        if (!$this->isCommentBookmarked($comment)) {
            throw new BookmarkNotCreated();
        }

        $this->bookmarkedComments()->detach($comment);
    }

    public function getBookmarkedCommentsByArticle(Article $article): Collection
    {
        return $article->relatedComments()
            ->whereIn('id', $this->bookmarkedComments()->select('id'))
            ->get();
    }

    public function updateLastActivityTime(): void
    {
        if (CarbonImmutable::now() > $this->login_at->addHour()) {
            $this->update(['login_at' => CarbonImmutable::now()]);
        }
    }

    /**
     * Need for AuthenticateSession middleware
     */
    public function getAuthPassword(): string
    {
        return $this->password->getHash();
    }

    public function articles(): HasMany
    {
        return $this->hasMany(Article::class, 'author_id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'author_id');
    }

    public function likedArticles(): BelongsToMany
    {
        return $this->belongsToMany(Article::class, 'liked_articles');
    }

    public function bookmarkedArticles(): BelongsToMany
    {
        return $this->belongsToMany(Article::class, 'bookmarked_articles');
    }

    public function bookmarkedComments(): BelongsToMany
    {
        return $this->belongsToMany(Comment::class, 'bookmarked_comments');
    }

    public function topics(): BelongsToMany
    {
        return $this->belongsToMany(Topic::class);
    }

    public function getAvatar(): ?Media
    {
        return $this->getFirstMedia('avatar');
    }

    /**
     * @throws FileDoesNotExist|FileIsTooBig
     */
    public function setAvatar(?UploadedFile $file): void
    {
        $this->media()
            ->where('collection_name', 'avatar')
            ->delete();

        if (!$file) {
            return;
        }

        $this->addMedia($file)
            ->usingFileName(sprintf('%s.%s', Str::uuid(), $file->guessExtension()))
            ->toMediaCollection('avatar');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('avatar')
            ->registerMediaConversions(function (Media $media) {
                $this->addMediaConversion('thumb')
                    ->width(300)
                    ->height(300);
            });
    }

    private function isCommentBookmarked(Comment $comment): bool
    {
        return $this->bookmarkedComments()
            ->where('id', $comment->id)
            ->exists();
    }
}

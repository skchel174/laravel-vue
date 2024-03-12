<?php

declare(strict_types=1);

namespace App\Models\User;

use App\Events\User\EmailChanged;
use App\Events\User\EmailChanging;
use App\Events\User\PasswordChanged;
use App\Events\User\PasswordReset;
use App\Events\User\UserRegistered;
use App\Exceptions\Article\ArticleNotPublished;
use App\Exceptions\User\BookmarkAlreadyCreated;
use App\Exceptions\User\BookmarkNotCreated;
use App\Exceptions\User\InvalidVerificationToken;
use App\Exceptions\User\PasswordResetNotRequested;
use App\Exceptions\User\RegistrationAlreadyVerified;
use App\Exceptions\User\SubscriptionAlreadyExists;
use App\Exceptions\User\SubscriptionNotExists;
use App\Exceptions\User\UnableFollowYourself;
use App\Exceptions\User\VerificationNotRequested;
use App\Exceptions\User\VerificationTokenExpired;
use App\Models\Article\Article;
use App\Models\Comment\Comment;
use App\Models\Topic\Topic;
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
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;

/**
 * @property-read int $id
 * @property string $login
 * @property string $email
 * @property string|null $name
 * @property string|null $about
 * @property string|null $new_email
 * @property Status $status
 * @property string|null $gender
 * @property CarbonImmutable|null $birthday
 * @property Password $password
 * @property Avatar|null $avatar
 * @property string $remember_token
 * @property VerifyToken $verify_token
 * @property-read CarbonImmutable $created_at
 * @property CarbonImmutable $updated_at
 * @property CarbonImmutable $login_at
 * @property-read Collection<Article> $articles
 * @property-read Collection<Bookmark> $bookmarks
 * @property-read Collection<Article> $bookmarkedArticles
 * @property-read Collection<Comment> $bookmarkedComments
 * @property-read Collection<Topic> $topics
 * @property-read Collection<User> $followings
 * @property-read Collection<User> $followers
 * @property-read Collection<Contact> $contacts
 *
 * @method static Builder whereLogin(string $login)
 * @method static Builder whereEmail(string $email)
 * @method static Builder whereVerifyToken(string $token)
 */
class User extends Model implements AuthenticatableInterface, AuthorizableInterface
{
    use HasFactory, Authenticatable, Authorizable;

    protected $fillable = [
        'login', 'email', 'name', 'about', 'status', 'gender', 'birthday', 'password', 'new_email', 'avatar', 'verify_token',
    ];

    protected $hidden = [
        'password', 'remember_token', 'verify_token',
    ];

    protected $casts = [
        'avatar' => Avatar::class,
        'status' => Status::class,
        'password' => Password::class,
        'verify_token' => VerifyToken::class,
        'created_at' => 'immutable_datetime:d-m-Y H:i:s',
        'updated_at' => 'immutable_datetime:d-m-Y H:i:s',
        'login_at' => 'immutable_datetime:d-m-Y H:i:s',
        'birthday' => 'immutable_datetime:d-m-Y',
    ];

    public static function register(string $login, string $email, Password $password): static
    {
        $user = static::create([
            'login' => $login,
            'email' => $email,
            'password' => $password,
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

    /**
     * Need for AuthenticateSession middleware
     */
    public function getAuthPassword(): string
    {
        return $this->password->getHash();
    }

    public function changePassword(Password $password): void
    {
        $this->update(['password' => $password]);

        Event::dispatch(new PasswordChanged($this));
    }

    public function updateLastActivityTime(): void
    {
        if (CarbonImmutable::now() > $this->login_at->addHour()) {
            $this->update(['login_at' => CarbonImmutable::now()]);
        }
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

    public function isFollow(User $user): bool
    {
        return $this->followings()
            ->where('id', $user->id)
            ->exists();
    }

    public function follow(User $user): void
    {
        if ($this->is($user)) {
            throw new UnableFollowYourself();
        }

        if ($this->isFollow($user)) {
            throw new SubscriptionAlreadyExists();
        }

        $this->followings()->attach($user);
    }

    public function unfollow(User $user): void
    {
        if (!$this->isFollow($user)) {
            throw new SubscriptionNotExists();
        }

        $this->followings()->detach($user);
    }

    public function articles(): HasMany
    {
        return $this->hasMany(Article::class, 'author_id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'author_id');
    }

    public function bookmarks(): HasMany
    {
        return $this->hasMany(Bookmark::class);
    }

    public function bookmarkedArticles(): BelongsToMany
    {
        return $this->morphedByMany(Article::class, 'bookmark', 'bookmarks');
    }

    public function bookmarkedComments(): BelongsToMany
    {
        return $this->morphedByMany(Comment::class, 'bookmark', 'bookmarks');
    }

    public function topics(): BelongsToMany
    {
        return $this->belongsToMany(Topic::class);
    }

    public function followers(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'followers',
            'user_id',
            'follower_id',
        );
    }

    public function followings(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'followers',
            'follower_id',
            'user_id',
        );
    }

    public function contacts(): HasMany
    {
        return $this->hasMany(Contact::class);
    }

    public function syncContacts(Collection $contacts): void
    {
        DB::transaction(function () use ($contacts) {
            $delete = $this->contacts()
                ->pluck('id')
                ->diff($contacts->pluck('id'));

            $this->contacts()
                ->whereIn('id', $delete)
                ->delete();

            $insert = $contacts->map(fn ($contact) => [
                'id' => $contact['id'] ?? null,
                'value' => $contact['value'],
                'contact_type_id' => $contact['contact_type_id'],
                'user_id' => $this->id,
            ])->toArray();

            $this->contacts()->upsert($insert, ['id'], ['value']);
        });
    }

    private function isCommentBookmarked(Comment $comment): bool
    {
        return $this->bookmarkedComments()
            ->where('id', $comment->id)
            ->exists();
    }
}

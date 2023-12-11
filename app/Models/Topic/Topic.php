<?php

declare(strict_types=1);

namespace App\Models\Topic;

use App\Models\Article\Article;
use App\Models\Category\Category;
use App\Models\Topic\Exceptions\UserAlreadySubscribed;
use App\Models\Topic\Exceptions\UserNotSubscribed;
use App\Models\User\User;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Throwable;

/**
 * @property-read int $id
 * @property string $name
 * @property string $slug
 * @property string $description
 * @property-read int|null $subscribers_count
 * @property-read int|null $articles_count
 * @property-read Category $category
 * @property-read Collection<Article> $articles
 * @property-read Collection<User> $subscribers
 * @property-read CarbonImmutable $created_at
 * @property-read CarbonImmutable $updated_at
 */
class Topic extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'name',
        'slug',
        'description',
    ];

    protected $casts = [
        'created_at' => 'immutable_datetime:d-m-Y H:i',
        'updated_at' => 'immutable_datetime:d-m-Y H:i',
    ];

    protected $with = ['media'];

    public static function createNew(string $name, string $description, Category $category): static
    {
        $topic = static::make([
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => $description,
        ]);
        $topic->category()->associate($category);
        $topic->save();

        return $topic;
    }

    public function isSubscribed(User $user): bool
    {
        return $this->subscribers()
            ->where('id', $user->id)
            ->exists();
    }

    /**
     * @throws Throwable
     */
    public function subscribe(User $user): void
    {
        if ($this->isSubscribed($user)) {
            throw new UserAlreadySubscribed();
        }

        $this->subscribers()->attach($user);
    }

    /**
     * @throws Throwable
     */
    public function unsubscribe(User $user): void
    {
        if (!$this->isSubscribed($user)) {
            throw new UserNotSubscribed();
        }

        $this->subscribers()->detach($user);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function articles(): BelongsToMany
    {
        return $this->belongsToMany(Article::class);
    }

    public function subscribers(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}

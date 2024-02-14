<?php

declare(strict_types=1);

namespace App\Models\Topic;

use App\Exceptions\Topic\UserAlreadySubscribed;
use App\Exceptions\Topic\UserNotSubscribed;
use App\Models\Article\Article;
use App\Models\Category\Category;
use App\Models\Localization\Localizable;
use App\Models\Tag\Tag;
use App\Models\User\User;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

/**
 * @property-read int $id
 * @property string $name
 * @property string $slug
 * @property string $description
 * @property string $icon
 * @property int $category_id
 * @property-read int|null $subscribers_count
 * @property-read int|null $articles_count
 * @property-read Category $category
 * @property-read Collection<Article> $articles
 * @property-read Collection<User> $subscribers
 * @property-read Collection<Tag> $tags
 * @property-read CarbonImmutable $created_at
 * @property-read CarbonImmutable $updated_at
 */
class Topic extends Model
{
    use HasFactory, Localizable;

    protected $fillable = ['name', 'slug', 'description', 'icon'];

    protected $casts = [
        'created_at' => 'immutable_datetime:d-m-Y H:i',
        'updated_at' => 'immutable_datetime:d-m-Y H:i',
    ];

    public static function createNew(string $name, string $description, string $icon, Category $category): static
    {
        $topic = static::make([
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => $description,
            'icon' => $icon,
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

    public function subscribe(User $user): void
    {
        if ($this->isSubscribed($user)) {
            throw new UserAlreadySubscribed();
        }

        $this->subscribers()->attach($user);
    }

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

    public function tags(): MorphToMany
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }
}

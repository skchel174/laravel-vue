<?php

declare(strict_types=1);

namespace App\Models\Post;

use App\Casts\Content;
use App\Casts\Title;
use App\Models\Post\Exceptions\PostAlreadyPublishedException;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;

/**
 * @property-read int $id
 * @property Title $title
 * @property Content $content
 * @property string|null $link
 * @property string $status
 * @property CarbonImmutable|null $publish_date
 * @property-read Carbon $created_at
 * @property-read Carbon $updated_at
 * @property Channel|null $channel
 * @property-read Collection<Category> $categories
 */
class Post extends Model
{
    use HasFactory;

    const MODERATION = 'moderation';
    const PUBLISHED = 'published';

    protected $casts = [
        'title' => Title::class,
        'content' => Content::class,
        'publish_date' => 'immutable_datetime:Y-m-d H:i:s',
    ];

    /**
     * @param Title $title
     * @param Content $content
     * @param Collection|null $categories
     * @return static
     */
    public static function create(Title $title, Content $content, ?Collection $categories = null): static
    {
        $post = new static();
        $post->title = $title;
        $post->status = self::MODERATION;
        $post->content = $content;
        $post->save();

        if ($categories && $categories->isNotEmpty()) {
            $post->categories()->attach($categories->pluck('id'));
        }

        return $post;
    }

    /**
     * @param Channel $channel
     * @param Title $title
     * @param Content $content
     * @param CarbonImmutable $publishDate
     * @param string $link
     * @param Collection|null $categories
     * @return static
     */
    public static function createFromChannel(
        Channel $channel,
        Title $title,
        Content $content,
        CarbonImmutable $publishDate,
        string $link,
        ?Collection $categories = null
    ): static {
        $post = new static();
        $post->title = $title;
        $post->content = $content;
        $post->status = self::PUBLISHED;
        $post->publish_date = $publishDate;
        $post->link = $link;
        $post->channel()->associate($channel);
        $post->save();

        if ($categories && $categories->isNotEmpty()) {
            $post->categories()->attach($categories->pluck('id'));
        }

        return $post;
    }

    /**
     * @param CarbonImmutable $date
     * @return void
     * @throws PostAlreadyPublishedException
     */
    public function publish(CarbonImmutable $date): void
    {
        if ($this->status === self::PUBLISHED) {
            throw new PostAlreadyPublishedException($this);
        }

        $this->status = self::PUBLISHED;
        $this->publish_date = $date;
        $this->save();
    }

    /**
     * @return BelongsTo
     */
    public function channel(): BelongsTo
    {
        return $this->belongsTo(Channel::class);
    }

    /**
     * @return BelongsToMany
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }
}

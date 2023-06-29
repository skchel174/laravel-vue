<?php

declare(strict_types=1);

namespace App\Models\Post;

use App\Casts\Title;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * @property-read int $id
 * @property Title $title
 * @property string $link
 * @property string $img
 * @property CarbonImmutable $last_build_date
 * @property string|null $description
 * @property-read Carbon $created_at
 * @property-read Carbon $updated_at
 * @property-read Collection<Post> $posts
 */
class Channel extends Model
{
    use HasFactory;

    protected $casts = [
        'title' => Title::class,
        'last_build_date' => 'immutable_datetime:Y-m-d H:i:s',
    ];

    public static function create(
        Title $title,
        string $link,
        string $img,
        CarbonImmutable $lastBuildDate,
        ?string $description = null
    ): static {
        $channel = new static();
        $channel->title = $title;
        $channel->link = $link;
        $channel->img = $img;
        $channel->last_build_date = $lastBuildDate;
        $channel->description = $description;

        $channel->save();

        return $channel;
    }

    /**
     * @return HasMany
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }
}

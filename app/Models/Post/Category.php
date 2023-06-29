<?php

declare(strict_types=1);

namespace App\Models\Post;

use App\Casts\Title;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;

/**
 * @property-read int $id
 * @property Title $title
 * @property-read Carbon $created_at
 * @property-read Carbon $updated_at
 * @property Collection<Post> $posts
 */
class Category extends Model
{
    use HasFactory;

    protected $casts = [
        'title' => Title::class,
    ];

    /**
     * @param Title $title
     * @return static
     */
    public static function create(Title $title): static
    {
        $category = new static();
        $category->title = $title;

        $category->save();

        return $category;
    }

    /**
     * @return BelongsToMany
     */
    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class);
    }
}

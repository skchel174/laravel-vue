<?php

declare(strict_types=1);

namespace App\Models\Topic;

use App\Models\Article\Article;
use App\Models\Category\Category;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

/**
 * @property-read int $id
 * @property string $name
 * @property string $slug
 * @property string $description
 * @property string $icon
 * @property-read Category $category
 * @property-read Collection<Article> $articles
 * @property-read CarbonImmutable $created_at
 * @property-read CarbonImmutable $updated_at
 */
class Topic extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'description', 'icon',
    ];

    protected $casts = [
        'created_at' => 'immutable_datetime:d-m-Y H:i',
        'updated_at' => 'immutable_datetime:d-m-Y H:i',
    ];

    public static function createNew(string $name, string $description, Category $category, ?string $icon = null): static
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

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function articles(): BelongsToMany
    {
        return $this->belongsToMany(Article::class);
    }
}

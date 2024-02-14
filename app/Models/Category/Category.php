<?php

declare(strict_types=1);

namespace App\Models\Category;

use App\Models\Article\Article;
use App\Models\Localization\Localizable;
use App\Models\Topic\Topic;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

/**
 * @property-read int $id
 * @property string $name
 * @property string $slug
 * @property-read Collection<Topic> $topics
 * @property-read Collection<Article> $articles
 * @property-read CarbonImmutable $created_at
 * @property-read CarbonImmutable $updated_at
 */
class Category extends Model
{
    use HasFactory, Localizable;

    protected $casts = [
        'created_at' => 'immutable_datetime:d-m-Y H:i',
        'updated_at' => 'immutable_datetime:d-m-Y H:i',
    ];

    protected $fillable = ['name', 'slug'];

    public static function createNew(string $name): static
    {
        return static::create([
            'name' => $name,
            'slug' => Str::slug($name),
        ]);
    }

    public function topics(): HasMany
    {
        return $this->hasMany(Topic::class);
    }

    public function articles(): BelongsToMany
    {
        return $this->belongsToMany(Article::class);
    }
}

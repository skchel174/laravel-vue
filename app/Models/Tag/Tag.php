<?php

declare(strict_types=1);

namespace App\Models\Tag;

use App\Models\Article\Article;
use App\Models\Localization\Localizable;
use App\Models\Localization\Localization;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

/**
 * @property-read int $id
 * @property string $name
 * @property string $slug
 * @property Collection<Article> $articles
 * @property-read Localization|null $localization
 * @property-read Carbon $updated_at
 */
class Tag extends Model
{
    use HasFactory, Localizable;

    protected $fillable = ['name', 'slug'];

    public static function createNew(string $name)
    {
        return static::create([
            'name' => $name,
            'slug' => Str::slug($name),
        ]);
    }

    public function articles(): BelongsToMany
    {
        return $this->belongsToMany(Article::class);
    }
}

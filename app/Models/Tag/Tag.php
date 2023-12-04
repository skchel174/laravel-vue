<?php

declare(strict_types=1);

namespace App\Models\Tag;

use App\Models\Article\Article;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;

/**
 * @property-read int $id
 * @property string $name
 * @property Collection<Article> $articles
 * @property-read Carbon $created_at
 * @property-read Carbon $updated_at
 */
class Tag extends Model
{
    use HasFactory;

    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Article::class);
    }
}

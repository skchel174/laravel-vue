<?php

declare(strict_types=1);

namespace App\Models\Category;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * @property-read int $id
 * @property string $name
 * @property string $slug
 * @property-read CarbonImmutable $created_at
 * @property-read CarbonImmutable $updated_at
 */
class Category extends Model
{
    use HasFactory;

    protected $casts = [
        'created_at' => 'immutable_datetime:d-m-Y H:i',
        'updated_at' => 'immutable_datetime:d-m-Y H:i',
    ];

    public static function createNew(string $name): static
    {
        $category = new Category();
        $category->name = $name;
        $category->slug = Str::slug($name);
        $category->save();

        return $category;
    }
}

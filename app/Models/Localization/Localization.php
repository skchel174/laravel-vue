<?php

declare(strict_types=1);

namespace App\Models\Localization;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property-read int $id
 * @property Locale $locale
 * @property array $value
 * @property-read Model $localizable
 * @property-read CarbonImmutable $created_at
 * @property-read CarbonImmutable $updated_at
 */
class Localization extends Model
{
    use HasFactory;

    protected $casts = [
        'locale' => Locale::class,
        'value' => 'array',
        'created_at' => 'immutable_datetime:d-m-Y H:i',
        'updated_at' => 'immutable_datetime:d-m-Y H:i',
    ];

    public function localizable(): MorphTo
    {
        return $this->morphTo();
    }
}

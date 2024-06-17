<?php

declare(strict_types=1);

namespace App\Models\User;

use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Database\Factories\User\VerifyTokenFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

/**
 * @property-read int $id
 * @property-read User $user
 * @property string $token
 * @property CarbonImmutable $created_at
 *
 * @method static VerifyTokenFactory factory($count = null, $state = [])
 */
class VerifyToken extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'token',
        'created_at',
    ];

    public static function generate(): VerifyToken
    {
        return static::make([
            'token' => Str::uuid(),
            'created_at' => CarbonImmutable::now(),
        ]);
    }

    public function regenerate(): void
    {
        $this->update([
            'token' => Str::uuid(),
            'created_at' => CarbonImmutable::now(),
        ]);
    }

    public function isEquals(string $token): bool
    {
        return $this->token === $token;
    }

    public function isExpired($timeout): bool
    {
        return Carbon::now() > $this->created_at->addSeconds($timeout);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected function casts(): array
    {
        return [
            'created_at' => 'immutable_datetime',
        ];
    }
}

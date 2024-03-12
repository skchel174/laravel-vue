<?php

declare(strict_types=1);

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property-read int $id
 * @property string $value
 * @property ContactType $contactType
 */
class Contact extends Model
{
    use HasFactory;

    protected $table = 'user_contacts';

    protected $fillable = ['user_id', 'contact_type_id', 'contact_id'];

    protected $with = ['contactType'];

    public function contactType(): BelongsTo
    {
        return $this->belongsTo(ContactType::class);
    }

    public function getUrl(): string
    {
        return strtr($this->contactType->template, [
            '{placeholder}' => $this->value,
        ]);
    }
}

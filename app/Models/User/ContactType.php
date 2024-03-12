<?php

declare(strict_types=1);

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

/**
 * @property-read int $id
 * @property string $name
 * @property string $icon
 * @property string $template
 * @property-read object|null $pivot
 */
class ContactType extends Model
{
    use HasFactory;

    protected $table = 'user_contact_types';

    protected $fillable = ['name', 'icon', 'template'];

    public function getIcon(): string
    {
        return Storage::disk('public')->url('img/' . $this->icon);
    }
}

<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Support\Arr;

enum Locale: string
{
    case En = 'en';
    case Ru = 'ru';

    public static function langsMap(): array
    {
        return Arr::mapWithKeys(Locale::cases(), function (Locale $locale) {
            return [$locale->value => $locale->lang()];
        });
    }

    public function lang(): string
    {
        return match ($this) {
            Locale::En => 'English',
            Locale::Ru => 'Russian',
        };
    }
}

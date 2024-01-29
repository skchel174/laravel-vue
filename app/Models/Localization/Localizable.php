<?php

declare(strict_types=1);

namespace App\Models\Localization;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;

/**
 * @property-read Collection $localization
 * @property-read Localization|null $currentLocalization
 *
 * @method MorphMany morphMany(string $class, string $string)
 */
trait Localizable
{
    public function getLocalizedValue(string $property)
    {
        $localization = $this->currentLocalization->first();

        if (isset($localization->value[$property])) {
            return $localization->value[$property];
        }

        return $this->{$property};
    }

    public function localization(): MorphMany
    {
        return $this->morphMany(Localization::class, 'localizable');
    }

    public function currentLocalization(): Model|MorphMany|null
    {
        return $this->localization()->where('locale', App::getLocale());
    }
}

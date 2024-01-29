<?php

declare(strict_types=1);

namespace Database\Factories\Tag;

use App\Models\Localization\Locale;
use App\Models\Tag\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;
use Str;

class TagFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $name = $this->faker->unique()->word(),
            'slug' => Str::slug($name),
        ];
    }

    public function withLocalization(Locale $locale, array $localization): static
    {
        return $this->afterCreating(function (Tag $tag) use ($locale, $localization) {
            $tag->localization()->create([
                'locale' => $locale,
                'value' => $localization,
            ]);
        });
    }
}

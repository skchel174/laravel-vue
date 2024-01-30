<?php

declare(strict_types=1);

namespace Database\Factories\Category;

use App\Models\Category\Category;
use App\Models\Localization\Locale;
use Illuminate\Database\Eloquent\Factories\Factory;
use Str;

class CategoryFactory extends Factory
{
    public function definition(): array
    {
        $name = $this->faker->word();

        return [
            'name' => $name,
            'slug' => Str::slug($name),
        ];
    }

    public function withLocalization(Locale $locale, array $localization): static
    {
        return $this->afterCreating(function (Category $category) use ($locale, $localization) {
            $category->localization()->create([
                'locale' => $locale,
                'value' => $localization,
            ]);
        });
    }
}

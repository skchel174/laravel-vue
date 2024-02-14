<?php

declare(strict_types=1);

namespace Database\Factories\Topic;

use App\Models\Category\Category;
use App\Models\Localization\Locale;
use App\Models\Topic\Topic;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class TopicFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $name = $this->faker->unique()->word(),
            'slug' => Str::slug($name),
            'description' => $this->faker->sentence(),
            'icon' => $this->faker->filePath(),
            'category_id' => Category::factory(),
        ];
    }

    public function withLocalization(Locale $locale, array $localization): static
    {
        return $this->afterCreating(function (Topic $topic) use ($locale, $localization) {
            $topic->localization()->create([
                'locale' => $locale,
                'value' => $localization,
            ]);
        });
    }

    public function withTags(Collection $tags): static
    {
        return $this->afterCreating(function (Topic $topic) use ($tags) {
           $topic->tags()->attach($tags);
        });
    }
}

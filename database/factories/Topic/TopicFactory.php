<?php

declare(strict_types=1);

namespace Database\Factories\Topic;

use App\Models\Category\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TopicFactory extends Factory
{
    public function definition(): array
    {
        $name = $this->faker->word();

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => $this->faker->sentence(),
            'category_id' => Category::factory(),
        ];
    }
}

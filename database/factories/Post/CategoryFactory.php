<?php

declare(strict_types=1);

namespace Database\Factories\Post;

use App\Casts\Title;
use App\Models\Post\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => Title::create($this->faker->unique()->sentence(1)),
        ];
    }
}

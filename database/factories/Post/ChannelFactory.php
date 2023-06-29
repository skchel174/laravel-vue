<?php

declare(strict_types=1);

namespace Database\Factories\Post;

use App\Casts\Title;
use App\Models\Post\Channel;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Channel>
 */
class ChannelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => Title::create($this->faker->unique()->sentence(3)),
            'link' => $this->faker->url(),
            'img' => $this->faker->url(),
            'last_build_date' => CarbonImmutable::now(),
            'description' => $this->faker->text(),
        ];
    }
}

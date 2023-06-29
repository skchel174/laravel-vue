<?php

declare(strict_types=1);

namespace Database\Factories\Post;

use App\Casts\Content;
use App\Casts\Title;
use App\Models\Post\Category;
use App\Models\Post\Channel;
use App\Models\Post\Post;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Collection;

/**
 * @extends Factory<Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => Title::create($this->faker->sentence(3)),
            'content' => Content::create($this->faker->text(), $this->faker->text()),
            'status' => Post::MODERATION,
        ];
    }

    /**
     * @param CarbonImmutable|null $date
     * @return PostFactory
     */
    public function published(?CarbonImmutable $date = null): PostFactory
    {
        $date ??= CarbonImmutable::now();

        return $this->state(fn (array $attrs) => [
            'status' => Post::PUBLISHED,
            'publish_date' => $date,
        ]);
    }

    /**
     * @param Channel $channel
     * @return PostFactory
     */
    public function withChannel(Channel $channel): PostFactory
    {
        return $this->state(function (array $attrs) use ($channel) {
            $state = [];

            if (empty($attrs['link'])) {
                $state['link'] = $channel->link;
            }

            if (!empty($attrs['publish_date'])) {
                if ($attrs['publish_date'] > $channel->last_build_date) {
                    $channel->last_build_date = $attrs['publish_date'];
                    $channel->save();
                }
            } else {
                $state['status'] = Post::PUBLISHED;
                $state['publish_date'] = $channel->last_build_date;
            }

            return $state;
        })->for($channel);
    }

    /**
     * @param Collection<Category> $categories
     * @return PostFactory
     */
    public function withCategories(Collection $categories): PostFactory
    {
        return $this->hasAttached($categories);
    }
}

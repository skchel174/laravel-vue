<?php

declare(strict_types=1);

namespace Database\Factories\Article;

use App\Models\Article\Difficulty;
use App\Models\Article\Status;
use App\Models\Localization\Locale;
use App\Models\User\User;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class ArticleFactory extends Factory
{
    public function definition(): array
    {
        return [
            'author_id' => User::factory(),
            'title' => $this->faker->sentence(3),
            'text' => $this->faker->text(5000),
            'summary' => $this->faker->text(),
            'difficulty' => Arr::random([null, ...Difficulty::cases()]),
            'lang' => Arr::random(Locale::cases()),
            'status' => Status::Published,
            'views' => rand(0, 5000),
            'created_at' => $date = new CarbonImmutable($this->faker->dateTimeThisYear),
            'updated_at' => null,
            'published_at' => $date->addDay(),
        ];
    }

    public function draft(): ArticleFactory
    {
        return $this->state(function (array $attrs) {
            return [
                'status' => Status::Draft,
                'published_at' => null,
            ];
        });
    }

    public function moderated(): ArticleFactory
    {
        return $this->state(function (array $attrs) {
            return [
                'status' => Status::Moderated,
                'published_at' => null,
            ];
        });
    }

    public function bookmarkedBy(User $user): ArticleFactory
    {
        return $this->hasAttached($user, relationship: 'bookmarks');
    }

    public function likedBy(User $user): ArticleFactory
    {
        return $this->hasAttached($user, relationship: 'likes');
    }

    public function withTopics(Collection $topics): ArticleFactory
    {
        $categories = $topics->pluck('category_id')->unique();

        return $this
            ->hasAttached($topics, relationship: 'topics')
            ->hasAttached($categories, relationship: 'categories');
    }

    public function withTags(Collection $tags): ArticleFactory
    {
        return $this->hasAttached($tags, relationship: 'tags');
    }
}

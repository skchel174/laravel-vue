<?php

declare(strict_types=1);

namespace Database\Factories\Article;

use App\Models\Article\Status;
use App\Models\User\User;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArticleFactory extends Factory
{
    public function definition(): array
    {
        return [
            'author_id' => User::factory(),
            'title' => $this->faker->sentence(3),
            'text' => $this->faker->text(1000),
            'summary' => $this->faker->text(),
            'status' => Status::Published,
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
}

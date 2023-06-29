<?php

declare(strict_types=1);

namespace Tests\Unit\Models\Post\Channel;

use App\Casts\Title;
use App\Models\Post\Channel;
use Carbon\CarbonImmutable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateTest extends TestCase
{
    use RefreshDatabase;

    public function testSuccessfullyCreate(): void
    {
        $faker = $this->getFaker();

        $channel = Channel::create(
            $title = Title::create($faker->sentence(3)),
            $link = $faker->url(),
            $img = $faker->url(),
            $lastBuildDate = CarbonImmutable::now(),
            $description = $faker->text(),
        );

        $this->assertInstanceOf(Channel::class, $channel);
        $this->assertModelExists($channel);
        $this->assertIsInt($channel->id);
        $this->assertEquals($channel->title, $title);
        $this->assertEquals($channel->link, $link);
        $this->assertEquals($channel->img, $img);
        $this->assertEquals($channel->last_build_date->getTimestamp(), $lastBuildDate->getTimestamp());
        $this->assertEquals($channel->description, $description);
    }
}

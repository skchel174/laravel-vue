<?php

declare(strict_types=1);

namespace Tests\Unit\Model\Topic;

use App\Models\Category\Category;
use App\Models\Topic\Topic;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateNewTest extends TestCase
{
    use RefreshDatabase;

    public function testCreateNewTopic(): void
    {
        /** @var Category $category */
        $category = Category::factory()->create();

        $topic = Topic::createNew(
            $name = $this->faker->word(),
            $description = $this->faker->sentence(),
            $icon = $this->faker->word(),
            $category,
        );

        $this->assertInstanceOf(Topic::class, $topic);
        $this->assertEquals($name, $topic->name);
        $this->assertEquals($description, $topic->description);
        $this->assertEquals($icon, $topic->icon);
        $this->assertTrue($topic->category->is($category));
        $this->assertTrue($topic->exists());
    }
}

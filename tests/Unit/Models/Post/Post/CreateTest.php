<?php

declare(strict_types=1);

namespace Tests\Unit\Models\Post\Post;

use App\Casts\Content;
use App\Casts\Title;
use App\Models\Post\Category;
use App\Models\Post\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateTest extends TestCase
{
    use RefreshDatabase;

    public function testSuccessfullyCreate(): void
    {
        $faker = $this->getFaker();

        $post = Post::create(
            $title = Title::create($faker->sentence(3)),
            $content = Content::create($faker->text(), $faker->text()),
            $categories = Category::factory()->count(2)->create()
        );

        $this->assertInstanceOf(Post::class, $post);
        $this->assertModelExists($post);
        $this->assertIsInt($post->id);
        $this->assertEquals($post->title, $title);
        $this->assertEquals($post->content, $content);
        $this->assertEquals($categories->pluck('id'), $post->categories->pluck('id'));
    }
}

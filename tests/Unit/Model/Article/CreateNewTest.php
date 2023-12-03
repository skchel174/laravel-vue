<?php

declare(strict_types=1);

namespace Tests\Unit\Model\Article;

use App\Models\Article\Article;
use App\Models\Article\Status;
use App\Models\User\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateNewTest extends TestCase
{
    use RefreshDatabase;

    public function testSuccessfullyCreateNewArticle(): void
    {
        $article = Article::createNew(
            $author = User::factory()->create(),
            $title = $this->faker->sentence(3),
            $text = $this->faker->text(),
            $summary = $this->faker->text(),
        );

        $this->assertInstanceOf(Article::class, $article);
        $this->assertModelExists($article);
        $this->assertIsInt($article->id);
        $this->assertEquals(Status::Draft, $article->status);
        $this->assertEquals($article->title, $title);
        $this->assertEquals($article->text, $text);
        $this->assertEquals($article->summary, $summary);
        $this->assertTrue($author->is($article->author));
    }
}

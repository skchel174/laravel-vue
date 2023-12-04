<?php

declare(strict_types=1);

namespace Tests\Unit\Model\Article;

use App\Models\Article\Article;
use App\Models\Article\Exceptions\ArticlePublished;
use App\Models\Article\Exceptions\ArticleWasNotModerated;
use App\Models\Article\Status;
use Carbon\CarbonImmutable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublishTest extends TestCase
{
    use RefreshDatabase;

    public function testSuccessfulPublishArticle(): void
    {
        /** @var Article $article */
        $article = Article::factory()
            ->moderated()
            ->create();

        $article->publish();

        $this->assertEquals(Status::Published, $article->status);
        $this->assertInstanceOf(CarbonImmutable::class, $article->published_at);
    }

    public function testPublishAlreadyPublishedArticle(): void
    {
        $this->expectException(ArticlePublished::class);

        /** @var Article $article */
        $article = Article::factory()->create();

        $article->publish();
    }

    public function testPublishNotModeratedArticle(): void
    {
        $this->expectException(ArticleWasNotModerated::class);

        /** @var Article $article */
        $article = Article::factory()
            ->draft()
            ->create();

        $article->publish();
    }
}

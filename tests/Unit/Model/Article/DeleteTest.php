<?php

declare(strict_types=1);

namespace Tests\Unit\Model\Article;

use App\Models\Article\Article;
use App\Models\Article\Status;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteTest extends TestCase
{
    use RefreshDatabase;

    public function testDeleteAlreadyDeletedArticle(): void
    {
        /** @var Article $article */
        $article = Article::factory()
            ->create(['status' => Status::Deleted]);

        $article->delete();

        $this->assertModelMissing($article);
    }

    public function testDeleteArticleDraft(): void
    {
        /** @var Article $article */
        $article = Article::factory()
            ->draft()
            ->create();

        $article->delete();

        $this->assertModelMissing($article);
    }

    public function testDeletePublishedArticle(): void
    {
        /** @var Article $article */
        $article = Article::factory()->create();

        $article->delete();

        $this->assertModelExists($article);
        $this->assertTrue($article->status === Status::Deleted);
        $this->assertNull($article->published_at);
    }
}

<?php

declare(strict_types=1);

namespace Tests\Unit\Model\Article;

use App\Models\Article\Article;
use App\Models\Article\Status;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RemoveTest extends TestCase
{
    use RefreshDatabase;

    public function testDeleteArticleDraft(): void
    {
        /** @var Article $article */
        $article = Article::factory()
            ->draft()
            ->create();

        $article->remove();

        $this->assertModelMissing($article);
    }

    public function testDeletePublishedArticle(): void
    {
        /** @var Article $article */
        $article = Article::factory()->create();

        $article->remove();

        $this->assertModelExists($article);
        $this->assertSoftDeleted($article);
        $this->assertTrue($article->status === Status::Deleted);
    }

    public function testDeleteSoftDeletedArticle(): void
    {
        /** @var Article $article */
        $article = Article::factory()->create([
            'status' => Status::Deleted,
            'deleted_at' => Carbon::now(),
        ]);

        $article->remove();

        $this->assertModelMissing($article);
    }
}

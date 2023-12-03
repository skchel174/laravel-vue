<?php

declare(strict_types=1);

namespace Tests\Unit\Model\Article;

use App\Models\Article\Article;
use App\Models\Article\Exceptions\ArticleModerated;
use App\Models\Article\Status;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ModerateTest extends TestCase
{
    use RefreshDatabase;

    public function testSendingArticleToModeration(): void
    {
        /** @var Article $article */
        $article = Article::factory()->create();

        $article->moderate();

        $this->assertEquals(Status::Moderated, $article->status);
    }

    public function testSendingModeratedArticleToModeration(): void
    {
        $this->expectException(ArticleModerated::class);

        /** @var Article $article */
        $article = Article::factory()->create([
            'status' => Status::Moderated,
        ]);

        $article->moderate();
    }
}
